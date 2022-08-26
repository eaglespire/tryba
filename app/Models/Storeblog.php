<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Storeblog extends Model
{
    use UsesUuid;
    protected $table = "store_blog";
    use HasFactory;
    public function cat()
    {
        return $this->belongsTo(Storeblogcat::class,'cat_id');
    }
}
