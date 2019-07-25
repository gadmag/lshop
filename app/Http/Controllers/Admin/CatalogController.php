<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\CatalogRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Gate;
use Carbon\Carbon;

use App\Seo;
use App\Catalog;
use App\Upload;
use App\Services\TreeService;
use Validator;
use Image;
use File;

class CatalogController extends Controller
{
    use TreeService;
    use UploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $catalogs = Catalog::whereParentId(0)->order()->get();
        return view('AdminLTE.catalog.index')->with([
            'catalogs' => $catalogs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        if (Gate::denies('create-post', Catalog::class)) {
            abort(403, 'Unauthorized action');

        }
        $tree = self::getTree(Catalog::all());
        return view('AdminLTE.catalog.create', [
            'tree' => $tree
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CatalogRequest $request)
    {
        $catalog = $this->createCatalog($request);
        return redirect("admin/catalogs")->with([
            'flash_message' => "{$catalog->name} добавлена",
//          'flash_message_important'     => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $catalog = Catalog::findOrFail($id);
        $tree = self::getTree(Catalog::excludeSelf($catalog->id)->get());
        if (Gate::denies('update-post', $catalog)) {
            abort(403, 'Unauthorized action');

        }

        return view('AdminLTE.catalog.edit', [
            'catalog' => $catalog,
            'tree' => $tree

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CatalogRequest $request, $id)
    {
        $catalog = $this->updateCatalog($request, Catalog::findOrFail($id));
        return redirect("admin/catalogs")->with([
            'flash_message' => "{$catalog->name} категория обновлена",
//          'flash_message_important'     => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $catalog = Catalog::findOrFail($id);

        if ($catalog->children) {
            $catalog->children()->update(['parent_id' => 0]);
        }
        $catalog->delete();
        return redirect("admin/catalogs")->with([
            'flash_message' => "'{$catalog->name}' категория удалена",
//          'flash_message_important'     => true
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    private function createCatalog(Request $request)
    {
        $catalog = Auth::user()->catalogs()->create($request->except('parent_id'));

        if($request->filled('catalogMenu.link_title'))
        {
            $catalog->catalogMenu()->create($request->catalogMenu + ['link_path' => $catalog->alias]);
        }

        if ($request->filled('catalogSeo')) {
            $catalog->catalogSeo()->create($request->catalogSeo);
        }

        $this->addParentCatalog($catalog, $request->parent_list);
        if($request->file('images')) {
            $this->multipleUpload($request->file('images'), $catalog, array('1250x700' => array('width' => 1250, 'height' => 700)));
        }
        return $catalog;

    }

    protected function updateCatalog(Request $request, $catalog)
    {
        $catalog->update($request->except('parent_id'));

        if($request->filled('catalogMenu.link_title'))
        {
            $catalog->catalogMenu()->updateOrCreate(['menu_linktable_id' => $catalog->id], $request->catalogMenu+['link_path' => $catalog->alias]);
        }
        else {
            $catalog->catalogMenu()->delete();
        }

        if ($request->filled('catalogSeo')) {
            $catalog->catalogSeo()->update($request->catalogSeo);
        }

        $this->addParentCatalog($catalog, $request->parent_list);
        if($request->file('images')) {
            $this->multipleUpload($request->file('images'), $catalog, array('1250x700' => array('width' => 1250, 'height' => 700)));
        }
        return $catalog;
    }


    /** Добавлнение родительской категории
     * @param Catalog $catalog
     * @param array $list
     */
    private function addParentCatalog(Catalog $catalog, $parent_id)
    {
        $depth = 0;
        if ($parent_id) {

            $parent = Catalog::findOrFail($parent_id);
            $parent_id = $parent->id;
            $depth = $parent->depth + 1;
        }
        $catalog->parent_id = $parent_id;
        $catalog->depth = $depth;
        $catalog->save();
    }
}
