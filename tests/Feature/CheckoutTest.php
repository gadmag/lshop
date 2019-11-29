<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\ShoppingCart\Facades\Cart;
use App\User;
use DatabaseSeeder;

class CheckoutTest extends TestCase
{

//    use RefreshDatabase;
    use WithFaker;

    public function setUp()
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }



    public function testGetCheckoutWithoutLogin()
    {
        $cart =  Cart::instance('cart')->toArray();
        $cart['totalPrice'] = 100;
        $response = $this->withSession(['cart' => $cart])->get(route('checkout'));
        $response->assertStatus(302);
        $response->assertRedirect('user/login');
    }


    /**
     * @dataProvider priceProvider
     * @param $price
     */
    public function testGetCheckout($price)
    {

        $cart =  Cart::instance('cart')->add(5,'names','file', $price)->toArray();
        $user = new User(['name' => 'admin']);
        $this->be($user);
        $response = $this->withSession(['cart' => json_encode(serialize($cart))])->get(route('checkout'));
        dd($response->exception->getTrace());
        if ($price < 1000){
            $response->assertStatus(302);
            $response->assertRedirect('shopping-cart');

        }else {
            $response->assertStatus(200);
            $response->setEtag('Оформить заказ');
        }

    }

    public function priceProvider()
    {
        return [
            ['price' => 1000.0],
            ['price' => 200.0],
            ['price' => 400.0],
        ];
    }

}
