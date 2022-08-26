<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Transactions extends Model {
    use UsesUuid;
    protected $table = "transactions";
    protected $guarded = [];
    protected $fillable = [
        'user_id',
        'ref_id',
        'currency',
        'receiver_id',
        'sender_id',
        'amount',
        'type',
        'reference',
        'trans_status',
        'first_name',
        'last_name',
        'ip_address',
        'email',
        'payment_type'
    ];

    public function ddlink()
    {
        return $this->belongsTo('App\Models\Paymentlink', 'payment_link');
    }
    public function inplan()
    {
        return $this->belongsTo('App\Models\Invoice', 'payment_link');
    }
    public function sender()
    {
        return $this->belongsTo('App\Models\User','sender_id');
    }
    public function receiver()
    {
        return $this->belongsTo('App\Models\User','receiver_id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User','receiver_id');
    }
    public function rex()
    {
        return $this->belongsTo('App\Models\Currency','currency');
    }
    public function getTransactions(){
        return ;
    }
}
