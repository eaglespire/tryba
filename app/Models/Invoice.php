<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Invoice extends Model {
    use UsesUuid;
    protected $table = "invoices";
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }   
    public function sender()
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
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    } 
}
