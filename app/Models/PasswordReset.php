<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class PasswordReset extends Model
{
    use UsesUuid;
    protected $table = "password_resets";
    protected $guard = [];
}
