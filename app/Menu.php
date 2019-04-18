<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Menu extends Model
{
    protected $table = 'menu_link';
    protected $fillable = ['link_title', 'parent_id','link_path', 'order', 'menu_linktable_id','menu_linktable_type', 'menu_type'];

    public $timestamps = false;

 protected static function getTree($tree, $pid=0) {
     $a = array();
     foreach ($tree as $row) {
         if ($row->parent_id == $pid) {

             $child = self::getTree($tree, $row->id);
             $children = $child?true:false;
             $a[] = array('item' => $row, 'children' => $children, 'child' => $child );
         }
     }

     if(count($a) == 0) {
         return null;
     }

     return $a;
 }
    public static function getMenuItem($type)
    {
        $menu = Menu::OfType($type)->orderBy('order')->get();
        return  self::getTree($menu);

    }

    public function scopeOfType($query,$type)
    {
        $query->where('menu_type', $type);
    }

    public function children()
    {
      return  $this->hasMany('App\Menu','parent_id', 'id');
    }

    public function menu_linktable()
    {
        return $this->morphTo();
    }

}
