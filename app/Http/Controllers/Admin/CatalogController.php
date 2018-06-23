<?php

namespace App\Http\Controllers\Admin;


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
use App\Alias;

use Validator;
use Image;
use File;

class CatalogController extends Controller
{

    use UploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $catalogs = Catalog::whereParentId(0)->order()->get();
//        dd($catalogs);
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
//        abort(403, 'Unauthorized action');
//        echo($user->name);
        if (Gate::denies('create-post', Catalog::class)) {
            abort(403, 'Unauthorized action');

        }
//        $catalogs = Catalog::doesntHave('parent')->pluck('name', 'id')->all();
        $catalogs = Catalog::doesntHave('parent')->pluck('name', 'id')->transform(function ($item){
            return $item;
        })->all();
//        dd($col);

        return view('AdminLTE.catalog.create', [
            'catalogs' => $catalogs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        $catalogs = Catalog::doesntHave('parent')->excludeSelf($catalog->id)->pluck('name', 'id')->all();

        if (Gate::denies('update-post', $catalog)) {
            abort(403, 'Unauthorized action');

        }

        return view('AdminLTE.catalog.edit', [
            'catalog' => $catalog,
            'catalogs' => $catalogs,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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

        $catalog = Auth::user()->catalogs()->create($request->all());

        if ($request->has('catalogSeo')) {
            $catalog->catalogSeo()->create($request->catalogSeo);
        }

        if ($request->parent_list[0]) {
            $this->addParentCatalog($catalog, $request->input('parent_list') ?: []);
        }

        $this->multipleUpload($request, $catalog, array('1250x700' => array('width' => 1250, 'height' => 700)));
        return $catalog;

    }

    protected function updateCatalog(Request $request, $catalog)
    {
        $catalog->update($request->all());

        if ($request->has('catalogSeo')) {
            $catalog->catalogSeo()->update($request->catalogSeo);
        }

        if ($request->parent_list[0]) {
                $this->addParentCatalog($catalog, $request->input('parent_list') ?: []);
        }
        $this->multipleUpload($request, $catalog, array('1250x700' => array('width' => 1250, 'height' => 700)));
        return $catalog;
    }


    /** Добавлнение родительской категории
     * @param Catalog $catalog
     * @param array $list
     */
    private function addParentCatalog(Catalog $catalog, array $list)
    {
        $catalog->parent_id = $list[0];
        $catalog->save();
    }
}
