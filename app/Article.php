<?php

namespace App;

use App\Services\TransliteratedService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class Article extends Model
{
    use Sluggable;

    protected $type = ['design', 'photo'];
    protected $fillable = ['title', 'type', 'body', 'user_id', 'status', 'alias'];


    protected $dates = ['published_at'];


    public function sluggable()
    {
        return [
            'alias' => [
                'source' => 'title'
            ]
        ];
    }


    public function getMetaTitleAttribute()
    {

        if ($this->articleSeo()->exists() && $this->articleSeo->meta_title) {
            return $this->articleSeo->meta_title;
        }

        if (setting('app_title')) {
            return setting('app_title');
        }
        return sprintf('%s | %s',setting('app_name'),$this->title);
    }

    public function getMetaDescriptionAttribute()
    {

        if ($this->articleSeo()->exists() && $this->articleSeo->meta_description) {
            return $this->articleSeo->meta_description;
        }
        if (setting('app_description')) {
            return setting('app_description');
        }
        return Str::words(strip_tags(trim($this->body)), 70);
    }

    public function getMetaKeywordsAttribute()
    {
        if ($this->articleSeo()->exists() && $this->articleSeo->meta_keywords) {
            return $this->articleSeo->meta_keywords;
        }
        if (setting('app_keywords')) {
            return setting('app_keywords');
        }
        return sprintf('%s | %s',setting('app_name'),$this->title);
    }

    public function setPublishedAtAttribute($date)
    {

        $this->attributes['published_at'] = Carbon::parse($date)->toDateString() . ' ' . Carbon::now()->toTimeString();
    }

    public function getPublishedAtAttribute($date)
    {
        $dt = Carbon::parse($date)->format('d.m.Y');
        return $dt;
    }



    public function setBodyAttribute($body)
    {
        if (!empty($body)) {
            $needle = "<hr />";
            $pos = strpos($body, $needle);
            if ($pos) {

                $this->attributes['description'] = substr($body, 0, $pos);
                $this->attributes['body'] = rtrim(substr($body, $pos + strlen($needle), strlen($body)));

            } else {
                $this->attributes['body'] = $body;
            }

        }
    }

    public function getImageMd5Attribute()
    {
        return md5('Image'.$this->id);
    }

    public function scopePublished($query)
    {
        $query->where('status', 1);
    }

    public function scopeUnpublished($query)
    {
        $query->where('status', 0);
    }

    public function scopeOfType($query, $type)
    {
        $query->where('type', $type);
    }

    public function getTagListAttribute()
    {

        return $this->tags->pluck('id')->all();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getCatalogListAttribute()
    {

        return $this->catalogs->pluck('id')->all();
    }

    public static function getArticleUser($id)
    {

        return DB::table('articles')->where([
            ['user_id', '=', $id],
            ['type', '=', 'news']
        ])
            ->limit(5)
            ->orderBy('published_at', 'desc')
            ->get();


    }


    public static function next($id, $type = 'news')
    {
        return Article::ofType($type)->where('id', '>', $id)->latest()->first();
    }

    public static function previous($id, $type = 'news')
    {
        return Article::ofType($type)->where('id', '<', $id)->latest()->first();
    }

    /**
     * Пулучиь теги для данной статьи
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'article_tag', 'article_id', 'tag_id')->withTimestamps();
    }

    /** Получить категории статьи
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function catalogs()
    {
        // return $this->belongsToMany('App\Catalog', 'product_catalog','product_id', 'catalog_id')->withTimestamps();
        return $this->morphToMany('App\Catalog', 'cataloggable');
    }

    /**
     * Получить  пользователя для данной статьи
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Получить файлы продуктов
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function files()
    {
        return $this->morphMany('App\Upload', 'uploadstable');
    }


    /** Seo аттрибуты статьи
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function articleSeo()
    {
        return $this->morphOne('App\Seo', 'seostable');
    }

    /** Получить атрибуты события текущей страницы
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function eventAttr()
    {
        return $this->hasOne('App\Event', 'article_id', 'id');
    }

    /** Получить атрибуты видео
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function videoAttr()
    {
        return $this->hasOne('App\VideoUrl', 'article_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function articleMenu()
    {

        return $this->morphOne('App\Menu', 'menu_linktable');
    }


    /**
     * Sync ids of created uploads
     * @param array $ids
     */
    public function syncUploads(array $ids): void
    {
        $old_uploads = $this->files->pluck('id')->toArray();
        if ($old_uploads) {
            $delete_id = array_diff($old_uploads, $ids);
            Upload::whereIn('id', $delete_id)->each(function ($upload, $key) {
                $upload->delete();
            });
        }
        $uploads = Upload::whereIn('id', $ids)->get();
        $this->files()->saveMany($uploads);
    }


}
