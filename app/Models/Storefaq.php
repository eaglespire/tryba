<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Storefaq extends Model
{
    protected $table = "store_faq";
    use HasFactory, UsesUuid;
    public function cat()
    {
        return $this->belongsTo(Storeblogcat::class,'cat_id');
    }
}
