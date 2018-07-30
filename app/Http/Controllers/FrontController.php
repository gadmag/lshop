<?php

namespace App\Http\Controllers;

use App\Catalog;
use App\Product;
use App\Special;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Page;
use App\Article;
use App\Menu;

class FrontController extends Controller
{


    public function index()
    {

        $product = new Product();
        $newProducts = $product->active()->latest('created_at')->take(8)->get();
        $specials = Product::has('productSpecial')->active()->take(4)->get();
//        $catalogProducts = Catalog::published()->findOrFail(1);
        $slides = Article::published()->ofType('photo')->latest('created_at')->take(5)->get();
        $designItem = Article::published()->ofType('design')->latest('created_at')->take(4)->get();

        return view('front', [
            'newProducts' => $newProducts,
            'specials' => $specials,
//            'catalogProducts' => $catalogProducts,
            'designItem' => $designItem,
            'slides' => $slides

        ]);
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function about()
    {
        $data = [];
        $data ['first'] = 'Douglas';
        $data ['last'] = 'Quaid';
        return view('pages.about')->with($data);
    }
}
