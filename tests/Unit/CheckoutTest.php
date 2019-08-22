<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Cart;
use App\User;

class CheckoutTest extends TestCase
{

    public function testGetCheckoutWithoutLogin()
    {
        $cart = new Cart(null);
        $cart->totalPrice = 100;
        $response = $this->withSession(['cart' => $cart])->get(route('checkout'));
        $response->assertResponseStatus(302);
        $response->assertRedirectedTo('user/login');
    }

    /**
     * @dataProvider priceProvider
     */
    public function testGetCheckout($price)
    {
        $cart = new Cart(null);
        $cart->totalPrice = $price;
        $user = new User(['name' => 'admin']);
        $this->be($user);
        $response = $this->withSession(['cart' => $cart])->get(route('checkout'));
        if ($price < 1000){
            $response->assertResponseStatus('302');
            $response->assertRedirectedTo('shopping-cart');

        }else {
            $response->assertResponseStatus(200);
            $response->seeText('Оформить заказ');
        }

    }

    public function priceProvider()
    {
        return [
            ['price' => 1000],
            ['price' => 400],
            ['price' => 200],
        ];
    }

    public function testPostCheckout()
    {

    }
}
