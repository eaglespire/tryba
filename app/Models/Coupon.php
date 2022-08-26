<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;


class Coupon extends Model
{
    use UsesUuid;
    protected $table = "coupon";
    protected $guarded = [];
    use HasFactory;
}
