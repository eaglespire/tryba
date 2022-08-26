<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestMoney extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'currency_id',
        'amount',
        'description',
        'payment_status',
        'status',
        'slug'
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class,'currency_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    
}
