<?php

namespace App;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Session;

class Cart
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;
    public $totalWeight = 0;
    public $coupon = null;

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
            $this->totalWeight = $oldCart->totalWeight;
            $this->coupon = $oldCart->coupon;
        }
    }

    public function add($item, $id, $option)
    {
        $totalPrice = 0;
        $totalWeight = 0;
        $quantity = ($option->quantity > 0) ? $option->quantity : 1;
        $option_id = $option->option_id;
        $frontImg = null;
        $productKey = self::searchCartKey($this->items, $id, $option_id);
        $price = $item->price;
        $weight = $item->weight;

        if($item->files()->exists()){
            $frontImg = $item->files()->first();
        }

        if ($option_id) {
            $productOption = $item->productOptions->find($option_id);
            if ($productOption->files()->exists()) {
                $frontImg = $productOption->files->first();
            }
            if ($productOption->color) $item->color = $productOption->color;
            if ($productOption->color_stone) $item->color_stone = $productOption->color_stone;

            $price = $productOption->price;
            $weight = $productOption->weight;
        }


        $storedItem = (Object)['qty' => 0, 'product_id' => $item->id, 'price' => $price, 'weight' => $weight,
            'option_id' => $option_id ? $option_id : null, 'frontImg' => $frontImg, 'item' => $item];


        if ($this->items) {
            if (!is_null($productKey)) {
                $storedItem = $this->items[$productKey];
            }
        }

        $storedItem->qty += $quantity;

        if ($item->productSpecial()->betweenDate()->exists()) {
            if ($item->productSpecial->price_prefix == '%') {
                $price = $price * intval($item->productSpecial->price) / 100;
            } else {
                $price = floatval($price - $item->productSpecial->price);
            }
        }

        if ($item->productDiscount()->exists() && $storedItem->qty >= $item->productDiscount->quantity) {

            if ($item->productDiscount->price_prefix == '%') {
                $price = $price * intval($item->productDiscount->price) / 100;
            } else {
                $price = floatval($price - $item->productDiscount->price);
            }
        }


        $item->price = $price;
        $storedItem->weight = $weight * $storedItem->qty;
        $storedItem->price = $price * $storedItem->qty;

        if (!is_null($productKey)) {
            $this->items[$productKey] = $storedItem;
        } else {
            $this->items[] = $storedItem;
        }


        foreach ($this->items as $cartItem) {
            $totalPrice += $cartItem->price;
            $totalWeight += $cartItem->weight;
        }
        $this->totalPrice = $totalPrice;
        $this->totalWeight = $totalWeight;
        $this->totalQty += $quantity;


    }


    public function reduceByOne($id)
    {
        $option_id = $this->items[$id]->option_id;
        $totalPrice = 0;
        $totalWeight = 0;
        $this->items[$id]->qty--;
        $item = $this->items[$id]->item;
        $price = $item->price ?: 0;
        $weight = $item->weight ?: 0;
        if ($option_id) {
            $productOption = $item->productOptions->find($option_id);

            $price = $productOption->price;
            $weight = $productOption->weight;
        }

        if ($item->productSpecial()->betweenDate()->exists()) {
            if ($item->productSpecial->price_prefix == '%') {
                $price = $price * intval($item->productSpecial->price) / 100;
            } else {
                $price = floatval($price - $item->productSpecial->price);
            }
        }

        if ($item->productDiscount()->exists() && $this->items[$id]->qty >= $item->productDiscount->quantity) {
            if ($item->productDiscount->price_prefix == '%') {
                $price = $price * intval($item->productDiscount->price) / 100;
            } else {
                $price = floatval($price - $item->productDiscount->price);
            }
        }

        $this->items[$id]->weight = $weight * $this->items[$id]->qty;
        $this->items[$id]->price = $price * $this->items[$id]->qty;

        $this->totalQty--;

        foreach ($this->items as $cartItem) {
            $totalPrice += $cartItem->price;
            $totalWeight += $cartItem->weight;
        }
        $this->totalPrice = $totalPrice;
        $this->totalWeight = $totalWeight;
        if ($this->items[$id]->qty <= 0) {
            array_splice($this->items, $id, 1);
        }
    }

    public function update($item, $id, $option)
    {
        $totalPrice = 0;
        $totalWeight = 0;
        $totalQty = 0;
        $quantity = ($option->quantity > 0) ? $option->quantity : 1;
        $option_id = $option->option_id ? $option->option_id : null;
        $frontImg = null;
        $productKey = self::searchCartKey($this->items, $id, $option_id);
        $price = $item->price;
        $weight = $item->weight;

        if($item->files()->exists()){
            $frontImg = $item->files()->first();
        }

        if ($option_id) {
            $productOption = $item->productOptions->find($option_id);

            if ($productOption->files()->exists()) {
                $frontImg = $productOption->files;
            }
            if ($productOption->color) $item->color = $productOption->color;
            if ($productOption->color_stone) $item->color_stone = $productOption->color_stone;

            $price = $productOption->price;
            $weight = $productOption->weight;
        }

        $storedItem = (object)['qty' => $quantity, 'product_id' => $item->id, 'price' => $price, 'weight' => $weight,
            'option_id' => $option_id ? $option_id : null, 'frontImg' => $frontImg, 'item' => $item];

        if ($this->items) {
            if (!is_null($productKey)) {
                $storedItem = $this->items[$productKey];
            }
        }


        if ($item->productSpecial()->exists()) {
            if ($item->productSpecial->price_prefix == '%') {
                $price = $price * intval($item->productSpecial->price) / 100;
            } else {
                $price = floatval($price - $item->productSpecial->price);
            }
        }

        if ($item->productDiscount()->exists() && $storedItem->qty >= $item->productDiscount->quantity) {
            if ($item->productDiscount->price_prefix == '%') {
                $price = $price * intval($item->productDiscount->price) / 100;
            } else {
                $price = floatval($price - $item->productDiscount->price);
            }
        }

        $storedItem->qty = $quantity;
        $item->price = $price;
        $storedItem->weight = $weight * $storedItem->qty;
        $storedItem->price = $price * $storedItem->qty;

        if (!is_null($productKey)) {
            $this->items[$productKey] = $storedItem;
        } else {
            $this->items[] = $storedItem;
        }


        foreach ($this->items as $cartItem) {
            $totalPrice += $cartItem->price;
            $totalWeight += $cartItem->weight;
            $totalQty += $cartItem->qty;
        }
        $this->totalPrice = $totalPrice;
        $this->totalWeight = $totalWeight;
        $this->totalQty = $totalQty;

    }

    public function removeItem($id)
    {

        $this->totalQty -= $this->items[$id]->qty;
        $this->totalPrice -= $this->items[$id]->price;
        $this->totalWeight -= $this->items[$id]->weight;
        array_splice($this->items, $id, 1);
    }


    /**
     * @param $items
     * @param $id
     * @return int|null
     */
    protected static function searchCartKey($items, $id, $option_id)
    {
        if (!$items) return null;
        foreach ($items as $key => $item) {
            if (($item->product_id == $id) && ($item->option_id == $option_id)) {
                return $key;
            }
        }
        return null;
    }
}
