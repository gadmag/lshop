<?php

namespace App\Http\Controllers;

use App\Catalog;
use App\Cart;
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

    public function index()
    {
        $products = Product::with('productUser')->active()->latest('created_at')->paginate(10);
        return view('product.index')->with('products', $products);
    }

    public function show(Product $product)
    {
//        $catalog = Catalog::findOrFail($product->catalogs()->first()->id);
//        $products = $catalog->products()->latest('published_at')->published()->get();
        return view('product.show', [
            'product' => $product,
            'options' => $product->productOptions,
            'discount' => $product->productDiscount,
            'special' => $product->productSpecial,
            'products' => null,

        ]);
    }


    public function addToCart(Request $request, $id)
    {

        $product = Product::with('files')->findOrFail($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id, $request->optionAddToCart);
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
//        return redirect()->route('product.shoppingCart');
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
        return view('shop.shopping-cart', [
            'products' => collect($cart->items),
            'totalPrice' => $cart->totalPrice
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
}