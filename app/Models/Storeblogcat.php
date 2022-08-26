<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Storeblogcat extends Model
{
    use UsesUuid;
    protected $table= "theme_blog_category";
    use HasFactory;
}
