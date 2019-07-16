<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $table = 'order_status';

    protected $fillable = ['name', 'css_class', 'is_default'];
    public $timestamps = false;

    public function orders()
    {
        return $this->hasOne('App\Order');
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', 1);
    }
    public function scopeNotDefault($query)
    {
        return $query->where('is_default', 0);
    }
}
