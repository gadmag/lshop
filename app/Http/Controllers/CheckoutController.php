<?php

namespace App\Http\Controllers;

use App\Events\OrderCreateEvent;
use App\Font;
use Illuminate\Http\Request;
use App\Payment;
use App\Shipment;
use App\ShoppingCart\Facades\Cart;
use App\Coupon;
use App\Http\Requests\CheckoutRequest;
use App\Order;
use App\Country;
use App\Region;
use App\OrderStatus;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;


class CheckoutController extends Controller
{

    /**
     * @var Collection
     */
    private $shipments;

    /**
     * @var Collection
     */
    private $payments;

    /**
     * @var Collection
     */
    private $countries;


    /**
     * @var array
     */
    private $config;


    public function __construct(Country $country)
    {
        $this->shipments = Shipment::getShipments();
        $this->payments = Payment::getPayments();
        $this->countries = $country->with('regions')->active()->get();
        $this->config = config('payment');
    }

    /**
     * @return mixed
     */
    public function getCheckout()
    {
        $cart = Cart::instance('cart');
        if (!$cart->isContent() || $cart->totalPrice() < $this->config['min_sum']) {
            return redirect()->route('product.shoppingCart');
        }
        $user = Auth::user();
        return view('shop.checkout', [
            'countries' => $this->countries,
            'config' => collect($this->config),
            'shipments' => $this->shipments,
            'payments' => $this->payments,
            'lastOrder' => $user->lastOrder(),

        ]);
    }

    public function postCheckout(CheckoutRequest $request)
    {

        $cart = Cart::instance('cart');

        if (!$cart->isContent()) {
            return redirect()->route('product.shoppingCart');
        }
        $order = Order::create($request->all());
        return redirect()->route('product.index')
            ->with('flash_message', 'Ваш заказ принят. Данные для оплаты будут отправленны на Вашу почту.');
    }


    public function validStepFirst(Request $request)
    {
        $this->validate($request,[
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'telephone' => 'required',
            'email' => 'required|email',
            'city' => 'required',
            'address' => 'required',
            'country' => 'required',
        ]);
        return response()->json(['message' => 'ok']);
    }

    public function validStepSecond(Request $request)
    {
        $this->validate($request,[
            'payment' => 'required',
            'shipment' => 'required'
        ]);
    }


}