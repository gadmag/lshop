<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FontRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Font;

class FontController extends Controller
{
    
    public function index(Request $request)
    {
        $fonts = Font::paginate(12);

        return view('AdminLTE.font.index')->with([
            'fonts' => $fonts,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('AdminLTE.font.create',[
        ]);
    }

    /**
     * @param FontRequest $request
     * @param Font $font
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Font $font, FontRequest $request)
    {
        $font->create($request->all());
        return  redirect("admin/fonts")->with([
            'flash_message'  =>   "Услуга {$font->title} добавлена",
        ]);
    }


    /**
     * @param Font $font
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Font $font,Request $request)
    {
        $type = $request->get('type')?:'engraving';
        return view('AdminLTE.font.edit', [
            'font' => $font,
            'type' => $type,

        ]);
    }

    /**
     * @param Font $font
     * @param FontRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Font $font, FontRequest $request)
    {
        $font->update($request->all());
        return redirect("admin/fonts")->with([
            'flash_message'   =>   "Услуга {$font->title} обновлена",
        ]);
    }

    /**
     * @param Font $font
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Font $font)
    {

        $title = $font->title;
        $font->delete();
        return redirect("admin/fonts")->with([
            'flash_message'   =>   "Услуга {$title} удалена",
        ]);
    }

}
