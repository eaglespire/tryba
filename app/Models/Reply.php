<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Reply extends Model {
    use UsesUuid;
    protected $table = "reply_support";
    protected $guarded = [];
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function staff()
    {
        return $this->belongsTo('App\Models\Admin','staff_id');
    }   
}
