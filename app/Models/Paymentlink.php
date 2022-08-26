<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Paymentlink extends Model {
    use UsesUuid;
    protected $table = "payment_link";
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    } 
    public function bb()
    {
        return $this->belongsTo('App\Models\Currency','currency');
    }
    public function cc()
    {
        return $this->belongsTo('App\Models\Countrysupported','user_id');
    }
}
