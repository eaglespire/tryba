<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Storefrontaddress extends Model {
    use UsesUUid;
    protected $table = "customer_address";
    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo('App\Models\Shipping','shipping_id');
    }      
    public function states()
    {
        return $this->belongsTo(Shipstate::class,'state','id');
    }    
    public function cities()
    {
        return $this->belongsTo('App\Models\Shipcity','city');
    }       
}
