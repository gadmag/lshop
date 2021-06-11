<?php


namespace App\ShoppingCart\Coupon;


class PercentDiscountCoupon extends DiscountCoupon
{
    /**
     * @var int
     */
    public $percent;

    public  $discount;

    public function __construct($name, $percent)
    {
        $this->percent = $percent;
        parent::__construct($name);
    }

    public function applyCoupon($total):float
    {
        $this->discount = round($total * (intval($this->percent) / 100),2);
        return $this->discount;
    }
}