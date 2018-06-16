<?php

namespace App\Http\Controllers;

use App\Catalog;
use Illuminate\Http\Request;

use App\Http\Requests;
//use Request;
use App\Articles;
use App\Alias;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{

    function __construct()
    {
        //return $this->middleware('auth',['expert' => 'index']);
    }

    public function index()
    {
        $articles = Articles::ofType('news')->latest('published_at')->published()->paginate(12);
        return view('articles.index')->with('articles', $articles);
    }

    public function indexPhoto()
    {
        $photos = Articles::ofType('photo')->latest('published_at')->published()->paginate(12);
        return view('articles.indexPhoto',[
            'photos' => $photos,
        ]);
    }

    public function indexVideo()
    {
        $videos = Articles::ofType('video')->latest('published_at')->published()->paginate(10);
        return view('articles.indexVideo',[
            'videos' => $videos,
        ]);
    }

    public function indexDate($year,$month)
    {
        if($month){
            $dateNews = Articles::published()->where(DB::raw('YEAR(published_at)'), '=', $year )->where(DB::raw('MONTH(created_at)'), '=',$month)->get();
        }else {
            $dateNews = Articles::published()->where(DB::raw('YEAR(published_at)'), '=', $year )->get();
        }

        return view('articles.indexDate',[
            'dateNews' => $dateNews,
            'year' => $year,
            'month' => $month
        ]);
    }

    public function show(Articles $article)
    {
        return view('articles.show', [
            'article' => $article,
            'userArticles' => Articles::getArticleUser($article->user->id),
            'next' => Articles::next($article->id),
            'previous' => Articles::previous($article->id),
        ]);
    }

    public function showCatNews($catAlias, Articles $article)
    {
        return view('articles.show', [
            'article' => $article,
            'userArticles' => Articles::getArticleUser($article->user->id),
            'next' => Articles::next($article->id),
            'previous' => Articles::previous($article->id),
        ]);
    }

    public function showPhoto(Articles $photo)
    {
        return view('articles.showPhoto', [
            'photo' => $photo,

            'next' => Articles::next($photo->id,'photo'),
            'previous' => Articles::previous($photo->id, 'photo'),
        ]);
    }

    public function showVideo(Articles $video)
    {
        return view('articles.showVideo', [
            'video' => $video,

            'next' => Articles::next($video->id,'video'),
            'previous' => Articles::previous($video->id, 'video'),
        ]);
    }

    public function showPage(Articles $article)
    {
        return view('articles.showPage', [
            'page' => $article,
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->get('search');

        $articles = Articles::published()->where('title', 'like', '%'.$search.'%')
        ->orWhere('body', 'like', '%'.$search.'%')->paginate(12);
        return view('articles.indexSearch',[
            'articles' => $articles
        ]);
    }

    public function feed()
    {
        $news = Articles::published()->OfType('news')->where('lang', '!=', 'no')->latest()->take(10)->get();

       // dd($news);
        return response()->view('xml.rss',[
            'news' => $news
        ])->header('Content-Type','text/xml');
    }

}