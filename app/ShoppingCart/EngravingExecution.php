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
        $engravingItem = new EngravingItem(
            $engraving['id'],
            $engraving['text'],
            $engraving['font'],
            $engraving['comment'],
            $engraving['filename'],
            $engraving['qty'],
            $cartId
        );
        if ($engraving['price']) {
            $engravingItem->setPrice($engraving['price']);
        }

        return $engravingItem;
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
        if ($cartItem->totalEngravingQty() > $cartItem->qty) {
            $cartItem->qty += ($cartItem->totalEngravingQty() - $cartItem->qty);
        }
        $this->applyDiscount($cartItem);
        $this->content->put($cartItem->getUniqueId(), $cartItem);
        $this->save();
        return $this;
    }

    public function updateEngraving(string $engravingId, array $engraving)
    {
        $cartId = $engraving['cartItemId'];
        $this->removeEngraving($cartId, $engravingId);
        $this->addEngraving($cartId, $engraving);

    }

    /**
     * @param $cartItemId
     * @param $engravingId
     * @return $this
     * @throws \Exception
     */
    public function removeEngraving($cartItemId, $engravingId)
    {
        if (!$this->has($cartItemId)) {
            throw new \Exception('Id not found in content');
        }
        $cartItem = $this->get($cartItemId);
        if ($cartItem->engravings->has($engravingId)) {
            $cartItem->engravings->forget($engravingId);
        }
        $this->applyDiscount($cartItem);
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
        return $this->content->map(function (CartItem $cartItem) {
            return $cartItem->getTotalEngravingFiles()->filter();
        })->flatten();
    }


    /**
     * @param string $engravingId
     * @return mixed
     * @throws \Exception
     */
    public function getEngraving(string $engravingId)
    {
        foreach ($this->content() as $cartItem) {
            if ($cartItem->engraving->has($engravingId)) {
                return $cartItem->engraving->get($engravingId);
            }
        }

        throw new \Exception('Engraving id not found in content');

    }

}