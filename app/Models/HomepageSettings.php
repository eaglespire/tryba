<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class HomepageSettings extends Model
{
    protected $table = "homepage_settings";
    protected $guarded = [];
    use HasFactory, UsesUuid;
}
