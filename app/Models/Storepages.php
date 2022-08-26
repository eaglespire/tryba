<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Storepages extends Model
{
    use UsesUuid;
    protected $table = "store_pages";
    use HasFactory;
}
