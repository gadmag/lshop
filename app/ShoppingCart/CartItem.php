<?php


namespace App\ShoppingCart;


use App\Product;

class CartItem
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
     * @var float
     */
    public $price;


    /**
     * @var string
     */
    public $name;


    /**
     * @var string
     */
    public $image;


    /**
     * @var float
     */
    public $weight;


    /**
     * @var int
     */
    public $qty;

    /**
     * @var array
     */
    public $options;


    /**
     * @var Product
     */
    public $item;


    public function __construct($id, $name, $image, $price, $weight, $qty,  $options = [])
    {

        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
        $this->price = (float)$price;
        $this->weight = (float)$weight;
        $this->qty = (int)$qty;
        $this->options = $options;

        $this->uniqueId = $this->generateUniqueId();
    }


    /**
     * @return string
     */
    protected function generateUniqueId()
    {
        if(!$this->options){
            return md5($this->id);
        }
        ksort($this->options);
        return md5($this->id . serialize($this->options));
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

    /** Get total weight cartItem
     * @return float
     */
    public function getWeight()
    {
        return $this->weight * $this->qty;
    }

    public function toArray()
    {
        return [
            'uniqueId' => $this->uniqueId,
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'price' => $this->price,
            'weight' => $this->weight,
            'qty' => $this->qty,
            'options' => $this->options,
            'item' => $this->item,
        ];
    }
}