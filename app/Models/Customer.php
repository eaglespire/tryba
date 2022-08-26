<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Customer extends Model {
    use UsesUuid;
    protected $table = "customer";
    protected $guarded = [];
    public function shipcountry()
    {
        return $this->belongsTo('App\Models\Shipcountry','country');
    }      
    public function shipstate()
    {
        return $this->belongsTo('App\Models\County','state');
    }           
    public function shipcity()
    {
        return $this->belongsTo('App\Models\Shipcity','city');
    }       
}
