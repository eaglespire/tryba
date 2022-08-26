<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Cart extends Model
{
    protected $table = "cart";
    protected $fillable = ['uniqueid', 'title', 'product', 'quantity','store', 'cost', 'total', 'size', 'color', 'length', 'weight'];
    public $timestamps = false;
    public function req()
    {
        return $this->belongsTo('App\Models\Product','product');
    }
}
