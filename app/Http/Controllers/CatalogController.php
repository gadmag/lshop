<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
//use Request;
use App\Articles;
use App\Alias;
use App\Catalog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CatalogController extends Controller
{

    function __construct()
    {
//        return $this->middleware('auth',['expert' => 'index']);
    }

    public function index()
    {

//       dd(\Auth::user()->articles);
        $catalogs = Catalog::latest('published_at')->published()->paginate(10);

        return view('catalog.index')->with('catalogs', $catalogs);
    }

    public function show(Catalog $catalog)
    {

//        $articles = $catalog->articles()->ofType('news')->latest('published_at')->published()->paginate(12);
        return view('catalog.show',[
//            'articles' => $articles,
            'catalog' => $catalog
        ]);

    }


}