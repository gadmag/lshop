<?php


namespace App\ShoppingCart;


use App\Product;
use Illuminate\Support\Collection;
use stdClass;

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
     * @var float
     */
    public $totalPrice;


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

    /**
     * @var Collection
     */
    public $engravings;

    /**
     * CartItem constructor.
     * @param $id
     * @param $name
     * @param $image
     * @param $price
     * @param $weight
     * @param $qty
     * @param array $options
     * @param Product $product
     */
    public function __construct($id, $name, $image, $price, $weight, $qty, $product, $options = [])
    {
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
        $this->price = (float)$price;
        $this->weight = (float)$weight;
        $this->qty = (int)$qty;
        $this->item = $product;
        $this->options = $options;
        $this->uniqueId = $this->generateUniqueId();
        $this->engravings = $this->engravings ?? new Collection();

    }


    /**
     * @return string
     */
    protected function generateUniqueId()
    {
        if (!$this->options) {
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
        return ($this->price * $this->qty) + $this->getTotalWithEngraving();
    }


    public function getTotalWithEngraving()
    {
        return $this->engravings->sum(function (EngravingItem $engravingItem) {
            return $engravingItem->getTotal();
        });
    }

    /**
     * Get total qty engravings
     * @return int
     */
    public function totalEngravingQty():int
    {
        return $this->engravings->sum(function (EngravingItem  $engravingItem){
            return $engravingItem->qty;
        });
    }

    /**
     * Get filename from CartItem
     * @return Collection
     */
    public function getTotalEngravingFiles()
    {
         return $this->engravings->map(function (EngravingItem $engravingItem){
                return $engravingItem->filename;
        });
    }

    /** Get total weight cartItem
     * @return float
     */
    public function getWeight()
    {
        return $this->weight * $this->qty;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'uniqueId' => $this->uniqueId,
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'price' => $this->price,
            'totalPrice' => $this->getTotal(),
            'weight' => $this->weight,
            'qty' => $this->qty,
            'options' => $this->options,
            'item' => $this->item,
        ];
    }
}