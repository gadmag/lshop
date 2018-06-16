<?php

namespace App\Http\Controllers\Admin;

use App\Alias;
use App\Event;
use App\Menu;
use App\Upload;
use App\VideoUrl;
use Illuminate\Http\Request;
use Gate;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Articles;
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

//    use UploadTrait;


    private $rules = [
        'title' => 'required|min:3',
        //'alias' => 'min:3|alpha_dash|unique:articles,alias'
        'alias' => 'min:3|alpha_dash',
        //'body' => 'required|min:3',
    ];
    public function __construct()
    {

    }

    /** Стати по типам
     * @param $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($type)
    {

       $articleType = $this->getArticleType($type);


        $articles = Articles::ofType($type)->latest('created_at')->paginate(10);


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
        $user = Auth::user();
//        abort(403, 'Unauthorized action');
//        echo($user->name);
//        auth()->logout();

        if (Gate::denies('create-post', Articles::class)) {
            abort(403, 'Unauthorized action');

        }

        $tags = \App\Tag::pluck('name', 'id');
        $catalogs = \App\Catalog::pluck('name', 'id');
        return view('AdminLTE.articles.create', compact('tags','type', 'catalogs'));

    }

//    public function createNews()

    /** Сохранить новую статью
     * @param Request $request
     * @param $type
     * @return \Illuminate\Http\RedirectResponse
     */

    public function store( Request $request, $type)

    {
        $articleType = $this->getArticleType($type);
       $request->request->add(['type' => $articleType->name]);

        $this->createArticle($request);


        //session()->flash('flash_message', 'Ваша статья добавленна');
        // session()->flash('flash_message_important', true);
        return  redirect("admin/article/{$articleType->name}/all")->with([
            'flash_message'               =>   "{$articleType->title} добавлена",
//          'flash_message_important'     => true
        ]);



    }

    public function edit($id)
    {
        $article = Articles::findOrFail($id);
        if (Gate::denies('update-post', $article)) {
            abort(403, 'Unauthorized action');
        }
        //$articleType = ArticleType::OfArticleType($type)->firstOrFail();
        $tags = \App\Tag::pluck('name', 'id');
        $catalogs = \App\Catalog::pluck('name', 'id');
//        dd($tags);
        return view('AdminLTE.articles.edit', [
            'article' => $article,
            'tags' => $tags,
             'catalogs' => $catalogs
        ]);
    }

    public function update($id, Requests\ArticleRequest $request)
    {
        $article = Articles::findOrFail($id);
        $images = $request->only('images');
        $article->update($request->except('seoAttr','eventAttr','menuLink','images[]'));

        if ($request->has('menuLink.link_title')){
            $this->updateMenuAttr($request, $article);
        }

        if ($request->has('seoAttr')) {
            $this->updateSeoAttr($request, $article);
        }
        if ($request->has('alias')) {
            $this->updateAliasAttr($request, $article);
        }
        if($request->has('eventAttr')){
            $this->updateEventAttr($request, $article->id);
        }

        if ($request->has('videoAttr')){
            $this->updateVideoAttr($request, $article->id);
        }


            $this->multipleUpload($request, $article,[

                '600x450' => array(
                    'width' => 600,
                    'height' => 450
                ),
                '400x300' => array(
                    'width' => 400,
                    'height' => 300
                )
            ]);

        $articleType = $this->getArticleType($article->type);
        $this->syncTags($article, $request->input('tag_list')? : []);
        $this->syncCatalogs($article,$request->input('catalog_list')? : []);
        return redirect("admin/article/{$article->type}/all")->with([
            'flash_message'               =>   "{$articleType->title} обновлена",
//          'flash_message_important'     => true
        ]);

    }

    /** Удаление статьи
     * @param Articles $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $article = Articles::findOrFail($id);
        $type = $article->type;
        $article->delete();
        return redirect("admin/article/{$type}/all")->with([
            'flash_message'               =>   "{$this->getArticleType($type)->title} удалена",
//          'flash_message_important'     => true
        ]);
    }
    /** Синхронизация тегов статьи
     * @param Articles $article
     * @param array $tags
     */
    private function syncTags(Articles $article, array $tags)
    {

        $article->tags()->sync($tags);
    }

    /** Синхронизация категорий продукта
     * @param Articles $article
     * @param array $catalogs
     */
    private function syncCatalogs(Articles $article, array $catalogs)
    {
        $article->catalogs()->sync($catalogs);
    }

    /** Сохранение новой статьи
     * @param Request $request
     */
    private function createArticle(Request $request)
    {
        $this->validate($request, $this->rules);

        $seo = $request->only('seoAttr');
        $event = $request->only('eventAttr');
        $video = $request->only('videoAttr');
        $menu = $request->only('menuLink')['menuLink'];
        $alias_url = $request->only('alias');
        $images = $request->only('images');
       // dd($alias_url);
        $article = Auth::user()->articles()->create($request->except('seoAttr','eventAttr','menuLink','images[]'));


        if(!empty($images['images']))
        {
           // dd($images['images']);
            $this->multipleUpload($request, $article,[
                '600x450' => array(
                    'width' => 600,
                    'height' => 450
                ),
                '400x300' => array(
                    'width' => 350,
                    'height' => null
                ),


            ]);
        }
        if ($request->has('alias'))
        {

           // $alias = new Alias($request->input('alias'));
            //$article->alias()->save($alias);
        }

        if ($request->has('seoAttr'))
        {
            $seo_attr = new Seo($request->input('seoAttr'));
            $article->seoAttr()->save($seo_attr);
        }

        if (!empty($event['eventAttr']))
        {
//            var_dump($event['eventAttr']);
            $event_attr = new Event($event['eventAttr']);
            $article->eventAttr()->save($event_attr);
        }

        if ($request->has('videoAttr'))
        {
            $video_attr = new VideoUrl($video['videoAttr']);
            $article->videoAttr()->save($video_attr);

        }

        if($request->input('hasMenu'))
        {

                $this->validate($request, ['menuLink.menu_title' =>'required_if:hasMenu,1|min:3']);
                $menu['link_path'] = $alias_url['alias'];
//                dd($menu);
                $menu_link = new Menu($menu);
//                dd($menu_link);
                $article->menuLink()->save($menu_link);

        }

         $this->syncCatalogs($article,$request->input('catalog_list')? : []);

          $this->syncTags($article,$request->input('tag_list')? : []);

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
        //dd($request->input('alias'));
        $this->validate($request, [
//            'alias' => 'min:3|alpha_dash|unique:articles,alias,' . $article->id
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
        if($request->input('hasMenu')){
            $this->validate($request, ['menuLink.link_title' =>'min:3|required_if:hasMenu,1']);
            $link_path = $request->input('alias');
            $article->menuLink()->updateOrCreate(['menu_linktable_id' => $article->id],array_merge($request->input('menuLink'),['link_path' => $link_path]));
        }
        else
        {
            $article->menuLink()->delete();
        }



    }

    /**  Обновление атрибутов события статьи
     * @param Request $request
     * @param $id
     */
    protected function updateEventAttr(Request $request, $id)
    {
        $this->validate($request, ['eventAttr.start_time' =>'required', 'eventAttr.end_time' => 'required']);

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