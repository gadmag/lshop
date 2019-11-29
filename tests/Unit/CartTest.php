<?php

namespace Tests\Unit;

use App\ShoppingCart\Coupon\FixedDiscountCoupon;
use App\ShoppingCart\Facades\Cart;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected $cart;

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @dataProvider additionAdd
     */
    public function testAdd($id, $name, $image, $price,
                            $weight, $qty, $options, $expected)
    {
        $cart = Cart::instance('cart')->add(
            $id,
            $name,
            $image,
            $price,
            $weight,
            $qty,
            $options
        );
        $this->assertEquals($expected, $cart->totalPrice());
    }

    /**
     * @dataProvider additionReduce
     */
    public function testReduce($id, $name, $image, $price,
                               $weight, $qty, $options, $expected)
    {
        $cart = Cart::instance('cart')->add(
            $id,
            $name,
            $image,
            $price,
            $weight,
            $qty,
            $options
        );
        $cart->reduceByOne($cart->content()->first()->getUniqueId());
        $this->assertEquals($expected, $cart->totalPrice());
        $this->assertEquals($qty-1, $cart->totalQty());
    }


    /**
     * @dataProvider additionAdd
     */
    public function testAddCoupon($id, $name, $image, $price,
                               $weight, $qty, $options, $expected)
    {
        $cart = Cart::instance('cart')->add(
            $id,
            $name,
            $image,
            $price,
            $weight,
            $qty,
            $options
        );
        $name = $this->faker->word;
        $cart->addCoupon($name, 30);
        $cart->addCoupon($name, 30);
        $total = $cart->totalPrice() - 30.0;
        $this->assertEquals($total, $cart->totalWithCoupons());

        $cart->addCoupon($this->faker->word, 10);
        $this->assertEquals($total - 10, $cart->totalWithCoupons());

    }

    public function additionAdd()
    {
        return [
            [1, 'dadad', 'file1', 50.0, 0, 2,
                [
                    'id' => 2,
                    'price' => 40.0,
                    'discount_quantity' => null,
                    'special_prefix' => null
                ],
                80.0
            ],
            [1, 'dadad', 'file1', 50.0, 0, 5,
                [
                    'id' => 3,
                    'price' => 50.0,
                    'discount_quantity' => 5,
                    'discount_price' => 40.0,
                    'special_prefix' => null
                ],
                200.0
            ],
            [1, 'dadad', 'file1', 50.0, 0, 3,
                [
                    'id' => 3,
                    'price' => 50.0,
                    'discount_quantity' => null,
                    'special_price' => 5.0,
                    'special_prefix' => '-'
                ],
                135.0
            ],
        ];
    }

    public function additionReduce()
    {
        return [
            [1, 'dadad', 'file1', 50.0, 0, 2,
                [
                    'id' => 2,
                    'price' => 40.0,
                    'discount_quantity' => null,
                    'special_prefix' => null
                ],
                40.0
            ],

            [1, 'dadad', 'file1', 50.0, 0, 3,
                [
                    'id' => 3,
                    'price' => 50.0,
                    'discount_quantity' => null,
                    'special_price' => 5.0,
                    'special_prefix' => '-'
                ],
                90.0
            ],
        ];
    }
}
