<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Productimage extends Model {
    use UsesUuid;
    protected $table = "product_image";
    protected $guarded = [];
}
