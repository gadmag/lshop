<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Menu extends Model
{
    protected $table = 'menu_link';
    public $timestamps = false;
    protected $fillable = ['title', 'parent_id', 'path', 'order', 'class', 'menu_linktable_id', 'menu_linktable_type', 'menu_type'];
    protected $appends = ['edit_path', 'destroy_path'];


    public function getEditPathAttribute()
    {
        return route('menus.edit', ['id' => $this->id]);
    }

    public function getDestroyPathAttribute()
    {
        return route('menus.destroy', ['id' => $this->id]);
    }

    public function getLinkPathAttribute()
    {
        switch ($this->menu_linktable_type){
            case 'App\Page':
                return route('page.show', ['id' => $this->path?:$this->menu_linktable_id]);
            case 'App\Catalog':
                return route('catalog.show', ['id' => $this->path?:$this->menu_linktable_id]);
        }
        return  url('/').$this->path;
    }

    public static function buildTree(&$elements, $parentId = 0)
    {

        $branch = array();

        foreach ($elements as &$element) {
            if ($element->parent_id == $parentId) {
                $children = self::buildTree($elements, $element->id);
                if ($children) {
                    $element->children = $children;
                }
                $branch[$element->id] = $element;
                unset($element);
            }
        }

        return $branch;
    }

    public static function getMenuItem($type)
    {
        $menu = Menu::OfType($type)->orderBy('order')->get();
        return self::buildTree($menu);
    }


    public function scopeOfType($query, $type)
    {
        $query->where('menu_type', $type);
    }

    public function children()
    {
        return $this->hasMany('App\Menu', 'parent_id', 'id');
    }

    public function menu_linktable()
    {
        return $this->morphTo();
    }

}
