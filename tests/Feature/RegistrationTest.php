<?php


namespace Test\Feature;

use App\User;
use App\Cart;
use Faker\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegistrationTest extends TestCase
{
//    use DatabaseMigrations;

    public function testRegistrationAvailable()
    {
        $response = $this->get(route('register',[],false));
        $response->assertResponseStatus(200);
    }

    public function testRegistrationFailed()
    {
        $response = $this->post(route('register',[],false));
        $response->assertResponseStatus(302);
        $response->assertRedirectedToRoute('front');
    }
    public function testRegistrationAction()
    {
        $email = Factory::create()->email;
        $response = $this->post(route('register',[],false),[
            'name' => 'Unit test',
            'email' => $email,
            'password' => '123123',
            'password_confirmation' => '123123',
        ]);
        $response->assertResponseStatus(302);
        $response->assertRedirectedToRoute('product.index');
        $user = User::whereEmail($email)->first();
        $this->assertNotNull($user);


    }

    public function testRegistrationCartSession()
    {
        $email = Factory::create()->email;
        $cart = new Cart(null);
        $cart->totalPrice = 1000;
        $this->withSession(['cart' => $cart]);
        $response = $this->post(route('register',[],false),[
            'name' => 'Unit test',
            'email' => $email,
            'password' => '123123',
            'password_confirmation' => '123123',
        ]);
        $response->assertResponseStatus(302);
        $response->assertRedirectedToRoute('product.shoppingCart');
        $user = User::whereEmail($email)->first();
        $this->assertNotNull($user);    }
}