<?php


namespace App\ShoppingCart\Coupon;


class FixedDiscountCoupon extends DiscountCoupon
{

    /**
     * @var float
     */
    public $discount;


    public function __construct($name, $discount)
    {
        parent::__construct($name);
        $this->discount = $discount;
    }

    /**
     * @param $total
     * @return float discount
     */
    public function applyCoupon($total)
    {
        return $this->discount;
    }
}