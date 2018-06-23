<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Menu;


class MenuController extends Controller
{
    public function index()
    {
        $type = request()->menu_type;

        $menu = Menu::getMenuItem($type);
        return view('AdminLTE.menu.index')->with([
            'menuItems' => $menu,
            'type' => $type,

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
            'link_title' => 'required',
            'link_path' => 'required',
            'menu_type' => 'in:secondmenu,mainmenu'
        ]);
        $menu = Menu::create($request->all());

        return redirect("admin/menu?menu_type=$menu->menu_type")->with([
            'flash_message' => "Пункт меню добавлен",
//          'flash_message_important'     => true
        ]);
    }


    public function update(Menu $menu, Request $request)
    {
        $menu->update($request->all());
        return redirect("admin/menu?menu_type=$menu->menu_type")->with([
            'flash_message' => "{$menu->link_title} обновлена",
//          'flash_message_important'     => true
        ]);
    }


    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $link_title = $menu->link_title;
        $menu_type = $menu->menu_type;
        $menu->delete();
        return redirect("admin/menu?menu_type=$menu_type")->with([
            'flash_message' => "{$link_title} удалена",
//          'flash_message_important'     => true
        ]);
    }

    public function updateMenuSort(Request $request)
    {
        $data = $request->input('jsonString');
        $itemMenu = json_decode($data, true);
        //dd($itemMenu);
        $item = self::saveTree($itemMenu);
        $i = 0;
        foreach ($item as $key => $value) {

            $menu = Menu::find($value['id']);
            $menu->order = $i;
            $menu->parent_id = $value['parent_id'];

            $menu->save();
            $i++;
        }
        return response(['status' => $item]);

    }

    public static function saveTree($itemMenu, $pid = 0)
    {
        $arr = array();
        foreach ($itemMenu as $key => $subItem) {

            $subArr = array();
            if (isset($subItem['children'])) {

                $subArr = self::saveTree($subItem['children'], $subItem['id']);

            }
            $arr[] = array('id' => $subItem['id'], 'order' => $key, 'parent_id' => $pid);
            $arr = array_merge($arr, $subArr);
        }

        if (count($arr) == 0) {
            return null;
        }

        return $arr;

    }
}
