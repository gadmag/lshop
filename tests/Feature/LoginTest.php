<?php


namespace Test\Feature;

use App\User;
use App\Cart;
use Faker\Factory;
use Illuminate\Support\Facades\Auth;
use TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegistrationTest extends TestCase
{

    public function testLoginAvailable()
    {
        $response = $this->get(route('login',[],false));
        $response->assertResponseStatus(300);
    }

    public function testLoginFailed()
    {
        $response = $this->post(route('login',[],false));
        $response->assertResponseStatus(302);
        $response->assertRedirectedToRoute('front');
    }
    public function testLoginAction()
    {
        $response = $this->post(route('login',[],false),[
//            'email' => 'admin@gmail.com',
//            'password' => '159753',
            'email' => 'user@gmail.com',
            'password' => '123456',
        ]);
        $user = Auth::user();
        $this->actingAs($user);
        $response->assertResponseStatus(302);
        if ($user->roles->first()->name == 'Admin'){
            $response->assertRedirectedTo('admin');
        }else {
            $response->assertRedirectedToRoute('user.profile');
        }

    }

    public function testLoginCartSession()
    {
        $cart = new Cart(null);
        $cart->totalPrice = 1000;
        $this->withSession(['cart' => $cart]);
        $this->assertSessionHas('cart');
        $response = $this->post(route('login',[],false),[
            'email' => 'user@gmail.com',
            'password' => '123456',
        ]);
        $user = Auth::user();
        $this->actingAs($user);
        $response->assertResponseStatus(302);
        $response->assertRedirectedToRoute('checkout');

    }
}