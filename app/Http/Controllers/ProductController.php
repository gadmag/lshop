<?php

namespace App\Http\Controllers;

use App\Catalog;
use App\Cart;
use App\FieldOption;
use App\WishList;
use App\Product;
use App\Order;
use App\Alias;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;


class ProductController extends Controller
{


    public function index(Request $request)
    {
        $filters = FieldOption::all(['type','name'])->groupBy('type');
        return view('product.index', ['filters' => $filters]);
    }

    public function getJsonProducts(Request $request)
    {
        $products = Product::with(['productOptions', 'files','productSpecial'])->active()->advancedFilter();
        return response()->json(['collection' => $products]);
    }

    public function show(Product $product)
    {
        $products = Product::whereHas('catalogs', function ($query) use ($product) {
            $query->where('id', $product->catalogs()->exists() ? $product->catalogs()->first()->id : null);
        })->whereNotIn('id', [$product->id])->active()->latest('created_at')->get()->take(4);
        return view('product.show', [
            'product' => $product,
            'options' => $product->productOptions()->with("files")->get(),
            'discount' => $product->productDiscount,
            'special' => $product->productSpecial()->betweenDate()->first(),
            'products' => $products,

        ]);
    }


    public function addToCart(Request $request, $id)
    {
        $product = Product::with(['files', 'productOptions.files'])->active()->largerQuantity()->findOrFail($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id, json_decode($request->get('options')));
        $request->session()->put('cart', $cart);
        $request->session()->save();
        return Response::json([
            'cart' => $cart
        ]);
    }

    public function getReduceByOne($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);
        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }
        return Response::json([
            'cart' => $cart
        ]);
    }

    public function getRemoveItem($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }
        return Response::json([
            'cart' => $cart
        ]);
    }

    public function getCartDetail()
    {
        if (Session::has('cart')) {
            $oldCart = session('cart');
            $cart = new Cart($oldCart);
            return Response::json([
                'cart' => $cart
            ]);
        } else {
            return Response::json([
                'cart' => null
            ]);
        }
    }

    public function getCart()
    {
        if (!Session::has('cart')) {
            return view('shop.shopping-cart', [
            ]);
        }
        $oldCart = session('cart');
        $cart = new Cart($oldCart);
        $paymentConfig = config('payment.cart_setting');
        return view('shop.shopping-cart', [
            'products' => collect($cart->items),
            'totalPrice' => $cart->totalPrice,
            'actionCheckout' => route('checkout'),
            'paymentConf' => $paymentConfig
        ]);
    }


    public function addToWishList(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $oldWishList = Session::has('wishList') ? Session::get('wishList') : null;
        $wishList = new WishList($oldWishList);
        $wishList->add($product, $product->id);
        $request->session()->put('wishList', $wishList);
        $request->session()->save();
        return Response::json([
            'wishList' => $wishList
        ]);
    }

    public function removeToWishList($id)
    {
        $oldWishList = Session::has('wishList') ? Session::get('wishList') : null;
        $wishList = new WishList($oldWishList);
        $wishList->remove($id);
        if (count($wishList->items) > 0) {
            Session::put('wishList', $wishList);
        } else {
            Session::forget('wishList');
        }
        return Response::json([
            'wishList' => $wishList
        ]);

    }

    public function getWishListJson()
    {
        if (Session::has('wishList')) {
            $oldWishList = session('wishList');
            $wishList = new WishList($oldWishList);
            return Response::json([
                'wishList' => $wishList
            ]);
        } else {
            return Response::json([
                'wishList' => null
            ]);
        }


    }

    public function getWishList()
    {
        if (!Session::has('wishList')) {
            return view('shop.wishList');
        }
        $oldWishList = session('wishList');
        $wishList = new WishList($oldWishList);
        return view('shop.wishList', [
            'wishList' => collect($wishList->items),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $search = $request->get('q');
        $products = Product::active()->where('title', 'like', '%' . $search . '%')->latest('created_at')->paginate(12);
        return view('product.search', [
            'products' => $products
        ]);
    }
}