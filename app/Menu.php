<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Menu
 *
 * @property int $id
 * @property string $link_title
 * @property int $parent_id
 * @property string $link_path
 * @property int $order
 * @property int $article_id
 * @property int $visible
 * @property string $menu_type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereLinkPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereLinkTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereMenuType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereVisible($value)
 * @mixin \Eloquent
 */
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
             $a[] = array('item' => $row, 'child' => $child );
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
