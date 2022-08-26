<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Merchant extends Model {
    use UsesUuid;
    protected $table = "merchants";
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }   

    public function coin()
    {
        return $this->belongsTo('App\Models\Countrysupported','pay_support');
    }
}
