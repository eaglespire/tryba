<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Sub extends Model {
    use UsesUuid;
    protected $table = "sub";
    protected $guarded = [];

}
