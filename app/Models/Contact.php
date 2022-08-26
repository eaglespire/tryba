<?php

namespace App\Models;
use App\Traits\UsesUuid;


use Illuminate\Database\Eloquent\Model;

class Contact extends Model {
    use UsesUuid;
    protected $table = "contact";
    protected $guarded = [];
}
