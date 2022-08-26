<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailAndSmsPricing extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity_email',
        'quantity_sms',
        'amount_email',
        'amount_sms'
    ];
}
