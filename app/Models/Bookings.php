<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Bookings extends Model
{
    use HasFactory, UsesUuid;
    
    public function storefront()
    {
        return $this->belongsTo(Storefront::class,'store_id');
    } 
    public function buyer()
    {
        return $this->belongsTo(Storefrontcustomer::class,'customer_id');
    }    
    public function service()
    {
        return $this->belongsTo(BookingServices::class,'service_id');
    }   
    public function ship()
    {
        return $this->belongsTo(Shipping::class,'ship_id');
    }    
    public function shipcountry()
    {
        return $this->belongsTo(Shipcountry::class,'country');
    }    
    public function shipstate()
    {
        return $this->belongsTo(Shipstate::class,'state');
    }    
}
