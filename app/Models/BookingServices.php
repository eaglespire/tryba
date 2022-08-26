<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\UsesUuid;

class BookingServices extends Model
{
    use HasFactory, UsesUuid, SoftDeletes;
    
    protected $fillable = [
        'store_id',
        'user_id',
        'image',
        'name',
        'price',
        'description',
        'duration',
        'durationType',
        'status'
    ];
    public function storefront()
    {
        return $this->belongsTo(Storefront::class,'store_id');
    } 

    public function sum_review()
    {
        return Bookings::whereservice_id($this->id)->sum('rating');
    }

    public function count_review()
    {
        return Bookings::whereservice_id($this->id)->wherereview(!null)->count();
    }

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function rating()
    {
        if ($this->count_review() == 0) {
            return $this->sum_review() / 1;
        } else {
            return $this->sum_review() / $this->count_review();
        }
    }
}
