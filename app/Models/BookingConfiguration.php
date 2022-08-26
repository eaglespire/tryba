<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'websiteID',
        'serviceType',
        'whereServiceRendered',
        'county',
        'city',
        'postCode',
        'dailyLimit',
        'collectReview',
        'businessHours',
        'startDateNoBookings',
        'endDateNoBookings',
        'status',
        'line'
    ];

    protected $casts = [
        'businessHours' => 'array',
        'startDateNoBookings' => 'date:d/m/Y',
        'endDateNoBookings' => 'date:d/m/Y',
    ];


}
