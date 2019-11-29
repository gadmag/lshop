<?php


namespace App\ShoppingCart\Coupon;


abstract class DiscountCoupon
{

    /**
     * @var string
     */
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    abstract public function applyCoupon($total);
}