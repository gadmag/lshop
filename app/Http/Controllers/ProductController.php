<?php

namespace App\Http\Controllers;

use App\Catalog;
use App\Coupon;
use App\Font;
use App\Http\Requests\CartRequest;
use App\Order;
use App\Service;
use App\Services\Filterable\ProductFilter;
use App\Shipment;
use App\ShoppingCart\Coupon\PercentDiscountCoupon;
use App\ShoppingCart\Facades\Cart;
use App\FieldOption;
use App\Services\Product\BaseQueries;
use App\WishList;
use App\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Session;


class ProductController extends Controller
{

    private $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function index(Request $request)
    {
        $filters = FieldOption::all(['type', 'name'])->groupBy('type');
        $filters['categories'] = Catalog::published()->get();
        return view('product.index', ['filters' => $filters]);
    }

    public function getJsonProducts(Request $request, BaseQueries $queries)
    {
        $products = $queries->getByCatalogFilter($request->cat_id);
        return response()->json(['collection' => $products]);
    }

    public function show(Product $product, BaseQueries $queries)
    {

        $products = $queries->getAllByCatalog($product);
        return view('product.show', [
            'product' => $product,
            'products' => $products,
        ]);
    }


    /**
     * Get products by search query
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $search = $request->get('keywords');
        $products = Product::with(['files', 'productSpecial', 'productOptions.files'])
            ->searchTitle($search);
        return view('product.search', [
            'count' => $products->count(),
            'products' => $products->paginate(12)->appends(request()->query()),
        ]);
    }


    /**
     * Get product json by search
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchJson(Request $request)
    {
        $search = $request->get('keywords', null);
        $products = Product::searchTitle($search);

        return response()->json([
            'count' => $products->count(),
            'products' => $products->limit(8)->get(),
        ]);
    }

    public function addToCart(CartRequest $request, $id)
    {
        $cart = $this->initCart();
        $options = $request->options;
        $product = Product::with(['files', 'services', 'productOptions.files'])->active()->largerQuantity()->findOrFail($id);
        $discount = $product->getDiscount($options['id']);
        $special = $product->getSpecial();
        $cart->add(
            $product->id,
            $product->title,
            $product->getFrontImages($options['id']),
            $product->getPrice($options['id']),
            $product->getWeight($options['id']),
            $options['quantity'],
            $product,
            [
                'id' => $options['id'],
                'color' => $product->getColor($options['id']),
                'color_stone' => $product->getColorStone($options['id']),
                'price' => $product->getPrice($options['id']),
                'discount_quantity' => $discount ? $discount->quantity : null,
                'discount_price' => $discount ? (float)$discount->price : null,
                'special_price' => $special ? (float)$special->price : 0,
                'special_prefix' => $special ? $special->price_prefix : null,
            ],
            $request->getEngraving()
        );

        return response()->json([
            'cart' => $cart->toArray()
        ]);
    }

    public function updateCart($uniqueId)
    {
        $cart = $this->initCart();
        $cart->update($uniqueId, request('quantity'));
        return response()->json([
            'cart' => $cart->toArray()
        ]);

    }

    public function reduceByOne($id)
    {
        $cart = Cart::instance('cart')->reduceByOne($id);
        return response()->json([
            'cart' => $cart->toArray()
        ]);
    }

    public function removeItem($uniqueId)
    {
        $cart = $this->initCart();
        $cart->removeItem($uniqueId);
        return response()->json([
            'cart' => $cart->toArray()
        ]);
    }

    /**
     * Add engraving from cart item
     * @param CartRequest $request
     * @param string cart item $uniqueId
     * @return \Illuminate\Http\JsonResponse
     */
    public function addEngraving(CartRequest $request, string $uniqueId)
    {
        $cart = $this->initCart();
        $cart->addEngraving($uniqueId, $request->options['engraving']);
        return response()->json([
            'cart' => $cart->toArray()
        ]);
    }

    public function updateEngraving(CartRequest $request, string $uniqueId)
    {
        $cart = $this->initCart();
        $cart->updateEngraving($uniqueId, $request->options['engraving']);
        return response()->json([
            'cart' => $cart->toArray()
        ]);
    }

    public function removeEngravingItem(Request $request)
    {
        $options = json_decode($request->options);
        $cart = $this->initCart();
        $cart->removeEngraving($options->keyCartItem, $options->keyEngraving);
        return response()->json([
            'cart' => $cart->toArray()
        ]);
    }

    public function getCartDetail()
    {
        return response()->json([
            'cart' => Cart::instance('cart')->toArray(),
        ]);
    }

    public function getCart()
    {
        $config = config('payment');
        $fonts = Font::all();
        return view('shop.shopping-cart', [
            'actionCheckout' => route('checkout'),
            'config' => $config,
            'fonts' => $fonts
        ]);
    }

    public function addCoupon(string $code, Coupon $coupon): JsonResponse
    {
        $cart = $this->initCart();
        $coupon = $coupon->getByCode($code);
        $cart->addCoupon($coupon);
        return response()->json([
            'cart' => $cart->toArray()
        ]);
    }

    public function addShipment(int $id, Shipment $shipment): JsonResponse
    {

        $price = request()->get('price', false);
        $cart = $this->initCart();
        $shipment = $shipment->getById($id);
        if(!$price){
            $price = $shipment->getShipmentPrice($cart->totalWeight());
        }
        $cart = $cart->addShipment(['id' => $shipment->id, 'title' => $shipment->title,
            'name' => $shipment->name, 'price' => $price]);

        return response()->json([
            'cart' => $cart->toArray()
        ]);
    }

    public function addToWishList(Request $request, $id): JsonResponse
    {
        $product = Product::findOrFail($id);
        $wishList = Cart::instance('wishList')->add($product->id, $product->title);
        return response()->json([
            'wishList' => $wishList->toArray()
        ]);
    }

    public function removeToWishList($id)
    {
        $wishList = Cart::instance('wishList')->removeItem($id)->toArray();
        return response()->json([
            'wishList' => $wishList
        ]);

    }

    public function getWishListJson()
    {
        return response()->json([
            'wishList' => Cart::instance('wishList')->toArray()
        ]);

    }

    public function getWishList(BaseQueries $queries)
    {
        $wishList = Cart::instance('wishList')->content();
        $products = $queries->getWishListProducts($wishList->pluck('id')->toArray());
        return view('shop.wishList', [
            'products' => $products,
        ]);
    }


    private function initCart()
    {
        $order = Order::whereId(request('order_id'))->first();
        $oldCart = $order ? $order->cart : null;
        $name = $oldCart ? 'order' : 'cart';
        return Cart::instance($name, $oldCart);
    }
}