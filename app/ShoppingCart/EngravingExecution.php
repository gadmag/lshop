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
     * @param string $uniqueId
     * @param array $engraving
     * @return $this
     * @throws \Exception
     */
    public function addEngraving(string $uniqueId, array $engraving)
    {
        if (!$this->has($uniqueId)) {
            throw new \Exception('Id not found in content');
        }
        $cartItem = $this->get($uniqueId);
        $engravingItem = $this->initEngraving($uniqueId, $engraving);
        if ($cartItem->engravings->has($engravingItem->getUniqueId())) {
            $engravingItem->qty += $cartItem->engravings->get($engravingItem->getUniqueId())->qty;
        }
        $cartItem->engravings->put($engravingItem->getUniqueId(), $engravingItem);
        $cartItem->calculate();
        $this->content->put($cartItem->getUniqueId(), $cartItem);
        $this->save();
        return $this;
    }

    /**
     * @param $cartItemId
     * @param $engravingId
     * @return $this
     * @throws \Exception
     */
    public function removeEngraving($cartItemId, $engravingId)
    {

        if(!$this->has($cartItemId)){
            throw new \Exception('Id not found in content');
        }
        $cartItem = $this->get($cartItemId);
        if ($cartItem->engravings->has($engravingId)) {
            $cartItem->engravings->forget($engravingId);
        }
        $this->save();
        return $this;
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

    /**
     * Get all files from cart
     * @return mixed
     */
    public function getEngravingsFiles()
    {
        return $this->content->map(function (CartItem $cartItem){
          return  $cartItem->getTotalEngravingFiles()->filter();
        })->flatten();
    }

}