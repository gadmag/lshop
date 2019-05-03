<?php

namespace App\Http\Controllers;

use App\FieldOption;
use App\Product;
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

    public function index()
    {

        $catalogs = Catalog::latest('published_at')->published()->paginate(10);

        return view('catalog.index')->with('catalogs', $catalogs);
    }

    public function show(Catalog $catalog)
    {
        $filters = FieldOption::all(['type', 'name'])->groupBy('type');
        return view('catalog.show',[
            'filters' => $filters,
            'category' => $catalog
        ]);

    }

}