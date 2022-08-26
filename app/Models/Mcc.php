<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mcc extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = "mcc";

    public function user() {
        return $this->belongsTo(User::class, 'id');
    }
}
