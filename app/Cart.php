<?php

namespace App;


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
        $optionPrice = 0;
        $optionWeight = 0;
        $quantity = ($option->quantity > 0) ? $option->quantity : 1;
        $option_id = $option->option_id;
        $productKey = self::searchCartKey($this->items, $id, $option_id);
        if ($option_id) {
            $productOption = $item->productOptions->find($option_id);
            $item->title = $item->title . "($productOption->color)";
            $optionPrice = floatval($productOption->price_prefix . $productOption->price);
            $optionWeight = floatval($productOption->weight_prefix . $productOption->weight);
        }
        $storedItem = ['qty' => 0, 'product_id' => $item->id, 'price' => $item->price, 'weight' => $item->weight, 'option_id' => $option_id ? $option_id : null, 'item' => $item];

        if ($this->items) {
            if (!is_null($productKey)) {
                $storedItem = $this->items[$productKey];
            }
        }

        $storedItem['qty'] += $quantity;
        $storedItem['weight'] = ($item->weight + $optionWeight) * $storedItem['qty'];
        if ($item->productDiscount()->exists() && $storedItem['qty'] >= $item->productDiscount->quantity) {
            $storedItem['price'] = ($item->productDiscount->price + $optionPrice) * $storedItem['qty'];
        } elseif ($item->productSpecial()->exists()) {
            $storedItem['price'] = ($item->productSpecial->price + $optionPrice) * $storedItem['qty'];
        } else {
            $storedItem['price'] = ($item->price + $optionPrice) * $storedItem['qty'];
        }


        if (!is_null($productKey)){
            $this->items[$productKey] = $storedItem;
        }else {
            $this->items[] = $storedItem;
        }


        foreach ($this->items as $cartItem) {
            $totalPrice += $cartItem['price'];
            $totalWeight += $cartItem['weight'];
        }
        $this->totalPrice = $totalPrice;
        $this->totalWeight = $totalWeight;
        $this->totalQty += $quantity;


    }

    public function reduceByOne($id)
    {
        $option_id = $this->items[$id]['option_id'];
        $discount_price = 0;
        $special_price = 0;
        $totalPrice = 0;
        $totalWeight = 0;
        $optionPrice = 0;
        $optionWeight = 0;
        $this->items[$id]['qty']--;
        $item = $this->items[$id]['item'];
        if ($option_id) {
            $productOption = $this->items[$id]['item']->productOptions->find($option_id);
            $optionPrice = floatval($productOption->price_prefix . $productOption->price);
            $optionWeight = floatval($productOption->weight_prefix . $productOption->weight);
        }

        $this->items[$id]['item']['weight'] = ($this->items[$id]['item']['weight'] + $optionWeight) * $this->items[$id]['qty'];
        if ($item->productDiscount()->exists() && $this->items[$id]['qty'] >= $item->productDiscount->quantity) {
            $discount_price = $item->productDiscount->price;
        }
        if ($item->productSpecial()->exists()) {
            $special_price = $item->productSpecial->price;
        }
        if ($discount_price > 0) {
            $this->items[$id]['price'] = $this->items[$id]['qty'] * ($discount_price + $optionPrice);
        } elseif ($special_price > 0) {
            $this->items[$id]['price'] = $this->items[$id]['qty'] * ($special_price + $optionPrice);
        } else {
            $this->items[$id]['price'] = $this->items[$id]['qty'] * ($this->items[$id]['item']['price'] + $optionPrice);
        }

        $this->totalQty--;

        foreach ($this->items as $cartItem) {
            $totalPrice += $cartItem['price'];
            $totalWeight += $cartItem['weight'];
        }
        $this->totalPrice = $totalPrice;
        $this->totalWeight = $totalWeight;
        if ($this->items[$id]['qty'] <= 0) {
            unset($this->items[$id]);
        }
    }

    public function removeItem($id)
    {
        $this->totalQty -= $this->items[$id]['qty'];
        $this->totalPrice -= $this->items[$id]['price'];
        $this->totalWeight -= $this->items[$id]['weight'];
        unset($this->items[$id]);
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
            if (($item['product_id'] == $id) && ($item['option_id'] == $option_id)) {
                return $key;
            }
        }
        return null;
    }
}
