<?php


namespace App;


class WishList
{
    public $items = [];
    public $totalQty = 0;

    public function __construct($oldCart)
    {
        if($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
        }
    }

    public function add($item, $id)
    {
//        $storedItem = ['item' => $item];
//        if ($this->items){
//            if (array_key_exists($id, $this->items)){
//                $storedItem = $this->items[$id];
//            }
//        }
//        $storedItem['qty']++;
        $this->items[$id] = $item;
        $this->totalQty++;

    }

    public function remove($id)
    {
        $this->totalQty -= 1;
        unset($this->items[$id]);
    }


}