<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Menu;


class MenuController extends Controller
{
    public function index(Request $request)
    {
        $menu = Menu::getMenuItem($request->menu_type);
//        dd($menu);
        return view('AdminLTE.menu.index')->with([
            'menuItems' => json_encode($menu),
            'type' => $request->menu_type,

        ]);

    }


    public function create()
    {
        $type = request()->menu_type;

        return view('AdminLTE.menu.create')->with([
            'type' => $type
        ]);
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('AdminLTE.menu.edit')->with([
            'menu' => $menu
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'path' => 'required',
            'menu_type' => 'in:second_menu,main_menu'
        ]);
        $menu = Menu::create($request->all());

        return redirect("admin/menus?menu_type=$menu->menu_type")->with([
            'flash_message' => "Пункт меню добавлен",
        ]);
    }


    public function update(Menu $menu, Request $request)
    {
        $menu->update($request->all());
        return redirect("admin/menus?menu_type=$menu->menu_type")->with([
            'flash_message' => "{$menu->title} обновлена",
        ]);
    }


    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $link_title = $menu->title;
        $menu_type = $menu->menu_type;
        $menu->delete();
        return redirect("admin/menus?menu_type=$menu_type")->with([
            'flash_message' => "{$link_title} удалена",
        ]);
    }

    public function updateTree(Request $request)
    {
        $items = json_decode($request->jsonString,true);
        $i = 0;
        foreach ($items as $key => $value) {
            $menu = Menu::find($value['id']);
            $menu->order = $i;
            $menu->depth = $value['depth'];
            $menu->parent_id = isset($value['parent_id'])? $value['parent_id'] :0;
            $menu->save();
            $i++;
        }
        return response(['status' => $items]);

    }

}
