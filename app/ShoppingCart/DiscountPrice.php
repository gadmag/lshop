<?php


namespace App\ShoppingCart;


trait DiscountPrice
{
    /**
     * @param $cartItem
     * @return void
     */
    private function applyDiscount(&$cartItem): void
    {
        if ($cartItem->options['discount_quantity'] && ($cartItem->options['discount_quantity'] <= $cartItem->qty)) {
            $cartItem->price = $cartItem->options['discount_price'];
            $cartItem->totalPrice = $cartItem->getTotal();
            return;
        } else {
            $cartItem->price = $cartItem->options['price'] ?: $cartItem->price;
        }
        if ($cartItem->options['special_prefix'] && ($cartItem->options['special_prefix'] == '%')) {
            $cartItem->price = $cartItem->price * intval($cartItem->options['special_price']) / 100;
        } elseif ($cartItem->options['special_prefix'] == '-') {
            $cartItem->price = floatval($cartItem->price - $cartItem->options['special_price']);
        }

        $cartItem->totalPrice = $cartItem->getTotal();
    }

    private function applyShippingPrice(): void
    {
        if ($this->totalPrice() >= setting('free_shipping')){
            $this->shipmentPrice = 0;
        }else {
            $this->shipmentPrice = $this->shipment['price'];
        }

    }
}