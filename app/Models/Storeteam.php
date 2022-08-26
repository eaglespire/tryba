<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\UsesUuid;


class Storeteam extends Model
{
    use UsesUuid;
    protected $table = "store_team";
    use HasFactory;
}
