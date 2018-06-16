<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

use App\Http\Requests;

class PageController extends Controller
{
    public function show(Page $page)
    {
        return view('page.show', [
            'page' => $page,
        ]);
    }
}
