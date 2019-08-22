<?php

namespace App\Http\Controllers;


use App\Page;
use App\Article;

class FrontController extends Controller
{

    public function index()
    {
        $slides = Article::published()->ofType('photo')->latest('created_at')->take(5)->get();
        $designItem = Article::published()->ofType('design')->latest('created_at')->take(4)->get();

        return view('front', [
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
