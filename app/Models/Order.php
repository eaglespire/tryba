<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Order extends Model {
    use UsesUuid;
    protected $table = "orders";
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id')->withTrashed();
    }      
    public function seller()
    {
        return $this->belongsTo('App\Models\User','seller_id');
    }     
    public function buyer()
    {
        return $this->belongsTo('App\Models\Storefrontcustomer','customer_id');
    }    
    public function storefront()
    {
        return $this->belongsTo('App\Models\Storefront','store_id');
    }    
    public function lala()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }    
    public function ship()
    {
        return $this->belongsTo('App\Models\Shipping','ship_id');
    }    
    public function shipcountry()
    {
        return $this->belongsTo('App\Models\Shipcountry','country');
    }    
    public function shipstate()
    {
        return $this->belongsTo('App\Models\Shipstate','state');
    }    
}
