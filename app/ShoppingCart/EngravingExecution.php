<?php


namespace App\ShoppingCart;


trait EngravingExecution
{

    public function initEngraving($cartId, $engraving)
    {
        return new EngravingItem(
            $engraving['id'],
            $engraving['text'],
            $engraving['filename'],
            $engraving['qty'],
            $cartId
        );
    }

    public function addEngraving(CartItem & $cartItem, $engraving)
    {
        $engravingItem = $this->initEngraving($cartItem->getUniqueId(), $engraving);
        $engravingItemId = $engravingItem->getUniqueId();
        $cartItemId = $cartItem->getUniqueId();
        if ($this->has($cartItemId) && $this->get($cartItemId)->engravings->has($engravingItemId)) {
            $engravingItem->qty += $this->get($cartItemId)->engravings->get($engravingItemId)->qty;
        }
        $cartItem->engravings->put($engravingItemId, $engravingItem);
    }


    public function removeEngraving($cartItemId, $engravingId)
    {

        if ($this->has($cartItemId)){
            $this->engravings->forget($engravingId);
        }
    }

    /**
     * @param CartItem $cartItem
     * @return mixed
     */
    public function getEngravingsByCartId(CartItem $cartItem)
    {
        return $this->engravings->filter(function (EngravingItem $engravingItem) use ($cartItemId) {
            return $engravingItem->cartItemId == $cartItemId;
        })->all();
    }


    /**
     * @param CartItem $cartItem
     * @return mixed
     */
    public function totalEngravingPrice(CartItem $cartItem)
    {
        return $cartItem->engravings->sum(function (EngravingItem $engravingItem) {
            return $engravingItem->getTotal();
        });
    }
}