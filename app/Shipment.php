<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Shipment extends Model
{

    protected $fillable = ['title', 'name', 'status', 'order', 'price_setting'];


    public function setPriceSettingAttribute($value)
    {
        $this->attributes['price_setting'] = serialize($value);
    }

    public function getPriceSettingAttribute($value)
    {
        return unserialize($value);
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    public function scopeOrder($query)
    {
        $query->orderBy('order', 'asc');
    }

    public static function getShipments()
    {
        return (new static)->with('files')->active()->order()->get();
    }

    public function files()
    {
        return $this->morphOne('App\Upload', 'uploadstable');
    }

    public function getById(int $id)
    {
        return $this->active()->whereId($id)->firstOrFail();
    }

    /** Get price by weight
     * @param $weight
     * @return mixed
     */
    public function getShipmentPrice($weight)
    {
        if (!$this->price_setting) {
            return 0;
        }

        foreach ($this->price_setting as $item) {
            if ($weight <= $item['weight']) {
                return (float)$item['price'];
            }
        }
        return (float)$this->price_setting[count($this->price_setting) - 1]['price'];

    }

    public function delete()
    {
        if ($this->files()->exists()) {
            Storage::disk('public')->delete('files/' . $this->files->filename);
            Storage::disk('public')->delete('files/thumbnail/' . $this->files->filename);
            $this->files()->delete();
        }
        return parent::delete();
    }
}
