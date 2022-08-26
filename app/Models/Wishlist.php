<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Wishlist extends Model {
    use UsesUuid;
    protected $table = "wishlist";
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }         
}
