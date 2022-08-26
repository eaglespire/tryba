<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class CustomerPasswordReset extends Model
{
    use UsesUuid;
    protected $table = "customer_password_resets";
    protected $guard = [];
}
