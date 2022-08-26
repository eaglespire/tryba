<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class openAccount extends Model
{
    use HasFactory;

    protected $fillable =[
       'newbusiness',
       'existingbusiness',
       'offer_service',
       'sell_online',
       'gender',
       'date_of_birth',
       'describe',
       'website',
       'turnover',
       'business_type',
       'business_name',
       'company_registration_number',
       'business_category',
       'postal_or_zipcode',
       'state',
       'address_one',
       'address_two',
       'user_id',
       'website_link',
       'web',
       'face',
       'instagram',
       'twitter',
    ];

}
