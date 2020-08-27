<?php


namespace App\ShoppingCart;


use App\Service;

class EngravingItem
{
    /**
     * @var string
     */
    private $uniqueId;

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /** Engraving type id
     * @var float
     */
    public $price;

    /** Engraving text
     * @var string
     */
    public $text;

    /**
     * @var string
     */
    public $filename;

    /**
     * @var int
     */
    public $qty;

    /**
     * @var string
     */
    public $cartItemId;

    /**
     * EngravingItem constructor.
     * @param int $id
     * @param string $text
     * @param string $filename
     * @param int $qty
     */
    public function __construct( $id, string $text, string $filename = '', int $qty = 1, $cartItemId)
    {
        $service = Service::findOrFail($id);
        $this->id = $id;
        $this->title = $service->title ;
        $this->price = (float)$service->price;
        $this->text = $text;
        $this->filename = $filename;
        $this->qty = (int)$qty;
        $this->cartItemId = $cartItemId;
        $this->uniqueId = $this->generateUniqueId();
    }

    public function generateUniqueId()
    {
      return  md5($this->id.''.$this->text.''.$this->filename);
    }

    /**
     * @return string
     */
    public function getUniqueId()
    {
        return $this->uniqueId;
    }

    /** Get total price cartItem
     * @return float
     */
    public function getTotal()
    {
        return $this->price * $this->qty;
    }
}