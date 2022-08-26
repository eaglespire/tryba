<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class ThemeSliders extends Model
{
    use UsesUuid;
    protected $table = "theme_sliders";
    use HasFactory;
}
