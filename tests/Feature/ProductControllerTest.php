<?php

namespace Tests\Feature;

use App\Coupon;
use Faker\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Product;
use App\ShoppingCart\Facades\Cart;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @var Cart
     */
    protected static $cart;

    /**
     * @var Product
     */
    protected static $product;

    /**
     * @var Coupon
     */
    protected static $coupon;

    public function setUp()
    {
        parent::setUp();
        self::$coupon = factory(Coupon::class)->create();
        self::$product = factory(Product::class)->create();
        self:: $cart = Cart::instance('cart')->add(5,'names','file', $this->faker->randomFloat(2));
    }


    public function testEmptyProduct()
    {
        $product = self::$product;
        $this->assertNotNull($product);
    }


    public function testShow()
    {
        $this->assertSame(1, 1);
        $this->visit(route('product.show', ['id' => self::$product->id]))
            ->see(self::$product->title);
    }


    public function testAddToCart()
    {
        $response = $this->post(route('product.addToCart', ["id" => self::$product->id]));
        $response->assertStatus(200);
        $response = $this->post(route('product.addToCart', ['id' => self::$product->id]));
        $response->assertStatus(200);
        $this->assertSessionHas('cart');
        static::$cart = Session::get('cart');
        $product = factory(\App\Product::class)->make([
            'quantity' => 0
        ]);
        $response = $this->post(route('product.addToCart', ['id' => $product->id]));
        $response->assertResponseStatus(404);

    }


    /**
     * @throws Exception
     */
    public function testReduceByOne()
    {
        $response = $this->withSession(['cart' => self::$cart])->get(route('product.reduceByOne', ['id' => self::$product->id]));
        $response->assertResponseStatus(200);
        $this->assertSessionHas('cart');

    }

    public function testGetCartDetail()
    {
        $response = $this->call('GET', route('product.shoppingCartDerail'));
        $this->assertSame(200, $response->status());
    }


    public function testGetCart()
    {
        $response = $this->get(route('product.shoppingCart'));
        $response->assertResponseStatus(200);
    }

    public function testRemoveItem()
    {
        $response = $this->withSession(['cart' => self::$cart])->get(route('product.removeItem', ['id' => self::$product->id]));
        $response->assertResponseStatus(200);
        $this->assertSessionMissing('cart');
    }

    public function testGetCoupons()
    {
        $response = $this->withSession(['cart' => json_encode(serialize(self::$cart->toArray()))])->get(route('product.addCoupon', ['code' => self::$coupon->code]));
        $cart = json_decode($response->content())->cart;
        $response->assertStatus(200);
        $this->assertEquals($cart->totalPrice - self::$coupon->discount, $cart->totalWithCoupons);


    }

    public function testSearch()
    {
        $url = route('product.search') . "?q=lor";
        $response = $this->get($url);
        $response->assertResponseStatus(200);
        $response->see('Поиск');
    }
}
