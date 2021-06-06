<?php

namespace App\ShoppingCart;

use App\ShoppingCart\Coupon\DiscountCoupon;
use App\ShoppingCart\Coupon\FixedDiscountCoupon;
use App\ShoppingCart\Coupon\PercentDiscountCoupon;
use Exception;
use App\ShoppingCart\Repositories\Contracts\RepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class Cart
{

    use EngravingExecution, DiscountPrice;

    const DEFAULT_INSTANCE_NAME = 'cart';

    /**
     * @var string
     */
    private $instanceName;

    /**
     * @var RepositoryInterface
     */
    private $repo;

    /**
     * @var Collection
     */
    private $engravings;

    /**
     * @var Collection
     */
    private $content;

    /**
     * @var Collection
     */
    private $coupons;

    /**
     * @var Collection
     */
    private $shipment;

    /**
     * total shipment price
     * @var float
     */
    private $shipmentPrice = 0;

    /**
     * Cart constructor.
     * @param RepositoryInterface $repo
     */
    public function __construct(RepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param string $name
     * @param null|array $oldCart
     * @return $this
     */
    public function instance(string $name = '', $oldCart = null)
    {
        $this->instanceName = $name ?: self::DEFAULT_INSTANCE_NAME;
        $this->fetch($oldCart);
        return $this;
    }

    /**
     * @param $id
     * @param null $title
     * @param string $image
     * @param int $price
     * @param int $weight
     * @param int $qty
     * @param null $product
     * @param null $options
     * @param null $engraving
     * @return $this
     * @throws Exception
     */
    public function add($id, $title = null, $image = '', $price = 0, $weight = 0, $qty = 1, $product = null, $options = null, $engraving = null)
    {
        $cartItem = new CartItem(
            $id,
            $title,
            $image,
            $price,
            $weight,
            $qty,
            $product,
            $options
        );

        $uniqueId = $cartItem->getUniqueId();

        if ($this->content->has($uniqueId)) {
            $cartItem->qty += $this->content->get($uniqueId)->qty;
            $cartItem->engravings = $this->content->get($uniqueId)->engravings;
        }

        $this->applyDiscount($cartItem);
        $this->content->put($uniqueId, $cartItem);
        if ($engraving['id']) {
            $this->addEngraving($uniqueId, $engraving);
        }
        $this->save();
        return $this;
    }


    /**
     * @param string $uniqueId
     * @param int $qty
     * @return $this
     * @throws Exception
     */
    public function update(string $uniqueId, int $qty)
    {
        if (!$this->has($uniqueId)) {
            throw new Exception('Id not found in content');
        }
        $cartItem = $this->get($uniqueId);
        $cartItem->qty = $qty;
        $this->applyDiscount($cartItem);
        $this->content->put($uniqueId, $cartItem);
        $this->save();
        return $this;
    }


    public function reduceByOne($uniqueId)
    {
        if (!$this->has($uniqueId)) {
            throw new Exception('Id not found in content');
        }
        $cartItem = $this->get($uniqueId);
        $cartItem->qty--;
        if ($cartItem->qty <= 0) {
            return $this->removeItem($uniqueId);
        }
        $this->applyDiscount($cartItem);
        $this->content->put($uniqueId, $cartItem);
        $this->save();
        return $this;
    }


    public function removeItem($uniqueId)
    {
        if ($cartItem = $this->has($uniqueId)) {
            $this->content->pull($uniqueId);
        }

        if (count($this->content()) <= 0) {
            $this->repo->unset($this->normalizeKey());
            return $this;
        }

        $this->save();
        return $this;

    }

    public function addCoupon($coupon): self
    {
        if (!$this->coupons->firstWhere('name', $coupon->name)) {

            if (($coupon->type === '%') && (intval($coupon->discount ) < 100)) {
                $this->coupons->push(new PercentDiscountCoupon($coupon->name, intval($coupon->discount)));
            } else {
                $this->coupons->push(new FixedDiscountCoupon($coupon->name, $coupon->discount));
            }
        }
        $this->save();
        return $this;
    }


    /**
     * @param array $shipment
     * @return $this
     */
    public function addShipment(array $shipment): self
    {
        $this->shipment = collect($shipment);
        $this->save();
        return $this;
    }

    public function getShipment(): Collection
    {
        return $this->shipment;
    }


    public function getTotalShipmentPrice(): float
    {
        if ($this->shipment->count() > 0) {
            $this->applyShippingPrice();
        }
        return $this->shipmentPrice;
    }

    /**
     * @param string $uniqueId
     * @return CartItem|null
     */
    public function get(string $uniqueId): ?CartItem
    {
        return $this->content->get($uniqueId);
    }

    /**
     * Get all content
     * @return Collection
     */
    public function content(): Collection
    {
        return $this->content;
    }

    public function isContent()
    {
        return $this->content->isNotEmpty();
    }


    /** Gel all coupon
     * @return Collection
     */
    public function coupons(): Collection
    {
        return $this->coupons;
    }

    public function shipment(): Collection
    {
        return $this->shipment;
    }


    protected function normalizeKey($key = null): string
    {
        if (!$key) {
            return $this->instanceName;
        }
        return sprintf('%s.%s', $this->instanceName, $key);

    }

    /**
     * @param string $uniqueId
     * @return bool
     */
    public function has(string $uniqueId): bool
    {
        return $this->content->has($uniqueId);
    }


    /**
     * Clear shopping cart
     */
    public function clear(): void
    {
        $this->content = new Collection();
        $this->engravings = new Collection();
        $this->shipment = new Collection();
        $this->coupons = new Collection();
        $this->save();
    }


    /** Save value in repository
     * @return $this
     */
    public function save()
    {
        $this->repo->set($this->normalizeKey(), json_encode(serialize($this->toArray())));
        return $this;
    }


    /**
     * Sync with storage
     * @param array $oldCart
     * @return $this|void
     */
    public function fetch($oldCart = null)
    {
        $cart = $this->getRepo($oldCart);
        if (!$cart) {
            $this->content = new Collection();
            $this->engravings = new Collection();
            $this->coupons = new Collection();
            $this->shipment = new Collection();
            return;
        }

        $this->content = collect($cart['content']);
        $this->engravings = collect($cart['engravings']);
        $this->coupons = collect($cart['coupons']);
        $this->shipment = collect($cart['shipment']);
        $this->instanceName = $cart['instance'];
        return $this;
    }


    public function getRepo($oldCart = null)
    {
        if (is_array($oldCart) && !$this->repo->exists($this->normalizeKey())) {
            return $oldCart;
        }
        $cart = $this->repo->get($this->normalizeKey());
        return $cart ? unserialize(json_decode($cart)) : null;
    }


    public function destroy($key = null)
    {
        $this->repo->unset($this->normalizeKey($key));
    }


    /**Get sum total price
     * @return float
     */
    public function totalPrice(): float
    {
        return $this->content->sum(function (CartItem $cartItem) {
            return $cartItem->getTotal();
        });

    }


    /**
     * @return float
     */
    public function totalWithCoupons()
    {
        $total = $this->totalPrice();
        $totalWithCoupons = $total;
        $this->coupons->each(function (DiscountCoupon $coupon) use ($total, &$totalWithCoupons) {
            $totalWithCoupons -= $coupon->applyCoupon($total);
        });
        if ($this->shipment->count() > 0) {
            $totalWithCoupons += $this->shipmentPrice;
        }
        return $totalWithCoupons;
    }


    /**Get sum total weight
     * @return float
     */
    public function totalWeight(): float
    {
        return $this->content->sum(function (CartItem $cartItem) {
            return $cartItem->getWeight();
        });
    }

    /**
     * Get sum qty
     *
     * @return int
     */
    public function totalQty(): int
    {
        return $this->content->sum(function (CartItem $cartItem) {
            return $cartItem->qty;
        });
    }


    /**
     * Get the unserialize instance
     * @return mixed
     */
    public function getContent()
    {
        return unserialize(json_decode($this->toArray()));
    }

    /**
     * Get the instance as an array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'content' => $this->content,
            'engravings' => $this->engravings,
            'coupons' => $this->coupons,
            'shipment' => $this->getShipment(),
            'shipmentPrice' => $this->getTotalShipmentPrice(),
            'instance' => $this->instanceName,
            'totalQty' => $this->totalQty(),
            'totalPrice' => $this->totalPrice(),
            'totalWithCoupons' => $this->totalWithCoupons(),
            'totalWeight' => $this->totalWeight(),
        ];
    }
}