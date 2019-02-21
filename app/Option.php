<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Option extends Model
{
    protected $fillable = ['product_id', 'color', 'color_stone', 'price', 'price_prefix', 'weight', 'weight_prefix', 'quantity'];
    protected $table = 'product_options';

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = (float)$value;
    }


    public function setWeightAttribute($value)
    {
        $this->attributes['weight'] = (int)$value;
    }


    public function optionProduct()
    {
        $this->belongsTo('App\Product');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function files()
    {
        return $this->morphOne('App\Upload', 'uploadstable');
    }


    public function delete()
    {
        if ($this->files()->exists()){
            Storage::disk('public')->delete('files/' . $this->files->filename);
            Storage::disk('public')->delete('files/thumbnail/' . $this->files->filename);
            Storage::disk('public')->delete('files/600x450/' . $this->files->filename);
            Storage::disk('public')->delete('files/250x250/' . $this->files->filename);
            Storage::disk('public')->delete('files/90x110/' . $this->files->filename);
            $this->files->delete();
        }

        return parent::delete();
    }
}
