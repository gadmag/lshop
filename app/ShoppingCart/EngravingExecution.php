<?php


namespace App\ShoppingCart;


trait EngravingExecution
{

    /**
     * Create EngravingItem object
     * @param $cartId
     * @param $engraving
     * @return EngravingItem
     */
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

    /**
     * Add engraving for CartItem
     * @param CartItem $cartItem
     * @param $engraving
     */
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
        if ($this->has($cartItemId) && $this->get($cartItemId)->engravings->has($engravingId)){
            $this->get($cartItemId)->engravings->forget($engravingId);
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