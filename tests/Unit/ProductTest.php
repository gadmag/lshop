<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Product;
use App\Cart;

class ProductTest extends TestCase
{
    protected static $cart;
    protected static $product;

    public function setUp()
    {
        parent::setUp();
        if (is_null(self::$product)) {
            self::$product = factory(\App\Product::class)->create();
        }
    }

    public function tearDown()
    {
        if ($this->getName() == 'testRemoveItem')
            Product::whereId(self::$product->id)->delete();
        parent::tearDown();
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
        $response->assertResponseStatus(200);
        $response = $this->post(route('product.addToCart', ['id' => self::$product->id]));
        $response->assertResponseStatus(200);
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


    public function testSearch()
    {
        $url = route('product.search')."?q=lor";
        $response = $this->get($url);
        $response->assertResponseStatus(200);
        $response->see('Поиск');
    }
}
