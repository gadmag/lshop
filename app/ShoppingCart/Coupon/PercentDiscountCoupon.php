<?php


namespace App\ShoppingCart\Coupon;


class PercentDiscountCoupon extends DiscountCoupon
{
    /**
     * @var int
     */
    public $percent;

    public function __construct($name, $percent)
    {
        $this->percent = $percent;
        parent::__construct($name);
    }

    public function applyCoupon($total):float
    {
        return $total * (intval($this->percent) / 100);
    }
}