<?php

namespace App\Models;

use App\Traits\UsesUuid;
use App\Models\Shipstate;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model {
    use UsesUuid;
    protected $table = "shipping";
    protected $guarded = [];
    
    public function real()
    {
        return $this->belongsTo('App\Models\Shipcountry','country');
    }    
    public function shippingState()
    {
        return $this->hasOne(Shipstate::class,'country_id','country');
    }
}
