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
        $catalog = Catalog::latest('created_at')->paginate(10);


        return view('AdminLTE.catalog.index')->with([
            'catalogs' => $catalog
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


        return view('AdminLTE.catalog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $catalog = $this->createCatalog($request);


        //session()->flash('flash_message', 'Ваша статья добавленна');
        // session()->flash('flash_message_important', true);
        return  redirect("admin/catalog")->with([
            'flash_message'               =>   "{$catalog->name} добавлена",
//          'flash_message_important'     => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Catalog $catalog)
    {
        if (Gate::denies('update-post', $catalog)) {
            abort(403, 'Unauthorized action');

        }

        return view('AdminLTE.catalog.edit', compact( 'catalog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Catalog $catalog)
    {
        $catalog->update($request->except('seoAttr','alias'));

        if ($request->has('seoAttr')) {
            $this->updateSeoAttr($request, $catalog->id);
        }

        if ($request->has('alias.alias_url')) {
            $this->updateAliasAttr($request, $catalog->id);
        }

       // if($request->has('images')){
            $this->multipleUpload($request, $catalog, array('1250x700' => array('width' => 1250, 'height' => 700)));
       // }


        return redirect("admin/catalog")->with([
            'flash_message'               =>   "{$catalog->name} категория обновлена",
//          'flash_message_important'     => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Catalog $catalog)
    {
        $catalog->delete();
        return redirect("admin/catalog")->with([
            'flash_message'               =>   "'{$catalog->name}' категория удалена",
//          'flash_message_important'     => true
        ]);
    }

    /**
     * @param Request $request
     */
    private function createCatalog(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:2',
            'alias.alias_url' => 'unique:aliases,alias_url|min:3'
        ]);


        $seo = $request->only('seoAttr');
        $alias = $request->only('alias');

        $catalog = Auth::user()->catalogs()->create($request->except('seoAttr','alias'));

        $this->multipleUpload($request, $catalog, array('1250x700' => array('width' => 1250, 'height' => 700)));

        if (!empty($seo['seoAttr']))
        {

            $seo_attr = new Seo($seo['seoAttr']);
            $catalog->seoAttr()->save($seo_attr);
        }

        if ($request->has('alias.alias_url'))//(!empty($alias['alias']))
        {

            $alias_attr = new Alias($alias['alias']);

            $catalog->alias()->save($alias_attr);
        }


        

        return $catalog;

    }



    /** Обновление seo атрибутов статьи
     * @param Request $request
     * @param $id
     */
    protected function updateSeoAttr(Request $request, $id)

    {
        $this->validate($request, ['seoAttr.title_seo' => 'min:3', 'seoAttr.keywords' => 'min:3', 'seoAttr.description' => 'min:3']);

        $seo_attr = Seo::firstOrCreate(['seotable_id' => $id]);

        $seo_attr->update($request->only('seoAttr')['seoAttr']);


    }

    protected function updateAliasAttr(Request $request, $id)

    {
        $alias_attr = Alias::firstOrCreate(['aliastable_id' => $id]);

        $this->validate($request, [
            'alias.alias_url' => 'min:3|unique:aliases,alias_url,' . $alias_attr->id
        ]);

       // dd($request->only('alias'));

        $alias_attr->update($request->only('alias')['alias']);


    }
}
