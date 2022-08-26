<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Storereview extends Model
{
    use UsesUuid;
    protected $table = "store_review";
    use HasFactory;
}
