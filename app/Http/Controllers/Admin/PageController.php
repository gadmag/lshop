<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PageRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Page;
use Auth;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::latest()->paginate(10);
        return view('AdminLTE.page.index',[
            'pages' => $pages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminLTE.page.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        $this->createPage($request);

        return  redirect("admin/pages/")->with([
            'flash_message'               =>   "Страница добавлена",
        ]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('AdminLTE.page.edit',[
            'page' => $page,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, $id)
    {
        $page = Page::findOrFail($id);
        $page->update($request->all());
        $this->updatePage($request, $page);
        return redirect()->route('pages.index',[
            'flash_message' => "Страница обновлена"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $title = $page->title;
        $page->delete();

        return redirect()->route('pages.index',[
            'flash_message' => "Страница {$title} удаленна"
        ]);
    }


    protected function createPage(Request $request)
    {
         $page =  Auth::user()->pages()->create($request->all());
        if($request->has('pageMenu.link_title'))
        {
            $page->pageMenu()->create($request->pageMenu + ['link_path' => $page->alias]);
        }

        if ($request->has('pageSeo'))
        {
            $page->pageSeo()->create($request->pageSeo);
        }

    }

    protected function updatePage(Request $request, $page)
    {
        if($request->has('pageMenu.link_title'))
        {
            $page->pageMenu()->updateOrCreate(['menu_linktable_id' => $page->id], $request->pageMenu + ['link_path' => $page->alias]);
        }
        else {
            $page->pageMenu()->delete();
        }

        if ($request->has('pageSeo'))
        {
            $page->pageSeo()->update($request->pageSeo);
        }

    }
}
