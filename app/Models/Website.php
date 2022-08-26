<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'websiteName',
        'websiteUrl',
        'theme_id',
        'meta_description',
        'meta_keyword',
        'mode',
        'status'
    ];

    public function bookingConfiguration(){
        return $this->hasOne(BookingConfiguration::class,'websiteID','id');
    }

    public function webCustomization(){
        return $this->hasOne(WebsiteCustomization::class,'websiteID','id');
    }

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
    public function services(){
        return $this->hasMany(BookingServices::class,'user_id','user_id');
    }
}
