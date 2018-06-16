<?php

namespace App\Http\Controllers;

use App\Catalog;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Page;
use App\Article;
use App\Menu;
class WelcomeController extends Controller
{


   public function index()
   {

       $page = Page::where('alias', 'front')->first();
       $dayNews = Article::published()->OfType('news')->latest('published_at')->take(6)->get();
//       $mainCatalog = Catalog::published()->where('alias','=','glavnoe')->first();

//       $mainCatalogArticles = $mainCatalog->articles()->published()->latest('published_at')->take(3)->get();

       return view('welcome',[
           'page' => $page,
            'dayNews' => $dayNews,
//           'mainCatalogArticles' => $mainCatalogArticles
       ]);
   }

   public  function contact()
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
