<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;

class TagsController extends Controller
{
    public function show(Tag $tag)
    {
       // return $tag->articles()->get();
        $articles = $tag->articles()->published()->get();

        return view('articles.index')->with('articles', $articles);
    }

}
