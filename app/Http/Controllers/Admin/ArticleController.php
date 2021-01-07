<?php

namespace App\Http\Controllers\Admin;

use App\Alias;
use App\Event;
use App\Menu;
use App\Upload;
use App\VideoUrl;
use App\Http\Requests\ArticleRequest;
use Gate;
use App\Http\Controllers\Controller;
use App\Article;
use App\ArticleType;
use App\Seo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Validator;
use Image;
use File;

class ArticleController extends Controller
{
    use UploadTrait;


    /** Стати по типам
     * @param $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($type)
    {
        $articleType = $this->getArticleType($type);
        $articles = Article::ofType($type)->latest('created_at')->paginate(10);
        return view('AdminLTE.articles.index')->with([
            'articles' => $articles,
            'articleType' => $articleType
        ]);
    }


    /** Форма добавления новой статьи
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($type)
    {
        $tags = \App\Tag::pluck('name', 'id');
        $catalogs = \App\Catalog::pluck('name', 'id');
        return view('AdminLTE.articles.create', compact('tags', 'type', 'catalogs'));

    }


    /**
     * Сохранить новую статью
     * @param ArticleRequest $request
     * @param $type
     * @return \Illuminate\Http\RedirectResponse
     */

    public function store(ArticleRequest $request, $type)
    {
        $articleType = $this->getArticleType($type);
        $request->request->add(['type' => $articleType->name]);

        $this->createArticle($request);

        return redirect("admin/articles/{$articleType->name}/all")->with([
            'flash_message' => "{$articleType->title} добавлена",
        ]);


    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);

        $tags = \App\Tag::pluck('name', 'id');
        $catalogs = \App\Catalog::pluck('name', 'id');
        return view('AdminLTE.articles.edit', [
            'article' => $article,
            'tags' => $tags,
            'catalogs' => $catalogs
        ]);
    }

    public function update(ArticleRequest $request, $id)
    {
        $article = Article::findOrFail($id);

        $article->update($request->all());

        if ($request->filled('menuLink.link_title')) {
            $this->updateMenuAttr($request, $article);
        }

        if ($request->filled('articleSeo')) {
            $article->articleSeo()->update($request->articleSeo);
        } else {
            $article->articleSeo()->delete();
        }

        if ($request->filled('eventAttr')) {
            $this->updateEventAttr($request, $article->id);
        }

        if ($request->filled('videoAttr')) {
            $this->updateVideoAttr($request, $article->id);
        }

        if ($request->exists('articleUpload')) {
            $article->syncUploads(explode(',', $request->articleUpload));
        }

        $articleType = $this->getArticleType($article->type);
        $this->syncTags($article, $request->input('tag_list') ?: []);
        $this->syncCatalogs($article, $request->input('catalog_list') ?: []);
        return redirect("admin/articles/{$article->type}/all")->with([
            'flash_message' => "{$articleType->title} обновлена",
        ]);

    }

    /** Удаление статьи
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        $article = Article::findOrFail($id);
        $type = $article->type;
        $article->delete();
        return redirect("admin/articles/{$type}/all")->with([
            'flash_message' => "{$this->getArticleType($type)->title} удалена",
        ]);
    }

    /** Синхронизация тегов статьи
     * @param Article $article
     * @param array $tags
     */
    private function syncTags(Article $article, array $tags)
    {

        $article->tags()->sync($tags);
    }

    /** Синхронизация категорий продукта
     * @param Article $article
     * @param array $catalogs
     */
    private function syncCatalogs(Article $article, array $catalogs)
    {
        $article->catalogs()->sync($catalogs);
    }

    /** Сохранение новой статьи
     * @param ArticleRequest $request
     */
    private function createArticle(ArticleRequest $request)
    {

        $article = Auth::user()->articles()->create($request->all());

        if ($request->filled('productSeo')) {
            $article->articleSeo()->create($request->productSeo);
        }

        if ($request->filled('eventAttr')) {
            $article->eventAttr()->create($request->eventAttr);
        }

        if ($request->filled('videoAttr')) {
            $article->videoAttr()->create($request->videoAttr);
        }

        if ($request->filled('articleMenu.link_title')) {
            $article->articleMenu()->create($request->articleMenu);
        }

        if ($request->exists('articleUpload')) {
            $article->syncUploads(explode(',', $request->articleUpload));

        }

        $this->syncCatalogs($article, $request->input('catalog_list') ?: []);

        $this->syncTags($article, $request->input('tag_list') ?: []);

    }


    /** Обновление seo атрибутов статьи
     * @param Request $request
     * @param $article
     */
    protected function updateSeoAttr(Request $request, $article)
    {
        $this->validate($request, ['seoAttr.title_seo' => 'min:3', 'seoAttr.keywords' => 'min:3', 'seoAttr.description' => 'min:3']);
        $article->seoAttr()->updateOrCreate($request->input('seoAttr'));


    }

    protected function updateAliasAttr(Request $request, $article)
    {
        $this->validate($request, [
            'alias' => 'min:3|alpha_dash|'
        ]);

        $article->alias = $request->input('alias');


    }

    /** Обновление атрибутов меню статьи
     * @param Request $request
     * @param $article
     */
    protected function updateMenuAttr(Request $request, $article)
    {
        if ($request->input('hasMenu')) {
            $this->validate($request, ['menuLink.link_title' => 'min:3|required_if:hasMenu,1']);
            $link_path = $request->input('alias');
            $article->menuLink()->updateOrCreate(['menu_linktable_id' => $article->id], array_merge($request->input('menuLink'), ['link_path' => $link_path]));
        } else {
            $article->menuLink()->delete();
        }


    }

    /**  Обновление атрибутов события статьи
     * @param Request $request
     * @param $id
     */
    protected function updateEventAttr(Request $request, $id)
    {
        $this->validate($request, ['eventAttr.start_time' => 'required', 'eventAttr.end_time' => 'required']);

        $seo_attr = Event::firstOrCreate(['article_id' => $id]);

        $seo_attr->update($request->only('eventAttr')['eventAttr']);
    }


    /** Обновление атрибутов видео
     * @param Request $request
     * @param $id
     */
    protected function updateVideoAttr(Request $request, $id)
    {
        //$this->validate($request, ['eventAttr.start_time' =>'min:']);
        $video_attr = VideoUrl::firstOrCreate(['article_id' => $id]);

        $video_attr->update($request->only('videoAttr')['videoAttr']);
    }


    /** Получить тип страницы
     * @param $type
     * @return mixed
     */
    protected function getArticleType($type)
    {
        return ArticleType::OfArticleType($type)->firstOrFail();
    }
}