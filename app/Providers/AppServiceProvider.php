<?php

namespace App\Providers;

use App\Block;
use Illuminate\Support\ServiceProvider;
use App\Articles;
use  App\Menu;
use App\Catalog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Blade::directive('current_convert', function ($number) {
            return "<?php echo number_format($number, 0, ',', ' '); ?>";
        });

        view()->composer(['catalog.list'], function($view){
            $view->with('catalogs', Catalog::latest('published_at')->published()->paginate(10));
        });


        view()->composer(['menu.nav','partials.footer'], function($view){

            $view->with('mainMenu', Menu::getMenuItem('main_menu'));
            $view->with('secondMenu', Menu::ofType('second_menu')->orderBy('order')->get());
        });


        view()->composer(['block.rightBottom'], function($view){
           $view->with('blocks', Block::published()->weight()->whereRegion('right_bottom')->get());
        });
        view()->composer(['block.rightTop'], function($view){
           $view->with('blocks', Block::published()->weight()->whereRegion('right_top')->get());
        });

        view()->composer(['articles.archiveNews'], function($view){
            $archNews = DB::table('articles')
                ->select(DB::raw('YEAR(published_at) year, MONTH(published_at) month, MONTHNAME(published_at) month_name, COUNT(*) article_count'))
                ->groupBy('year')
                ->groupBy('month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->where('status', 1)
                ->where('type', 'news')
                ->take(10)
                ->get();
           $view->with('archNews', $archNews);
        });

        view()->composer(['partials.blockAllNews'], function($view){
            $view->with('allNews', Catalog::published()->whereNotIn('name',['Главные новости','Редакция', 'Документы','Архив выпусков'])->get());
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path() . '/Helpers/DateFormat.php';
    }
}
