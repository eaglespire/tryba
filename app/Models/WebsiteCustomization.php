<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteCustomization extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'websiteID',
        'menus',
        'slider',
    ];

    protected $casts = [
        'menus' => 'array',
        'slider' => 'array',
    ];
}
