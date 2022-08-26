<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Charges extends Model {
    use UsesUuid;
    protected $table = "charges";
    protected $guarded = [];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    } 
}
