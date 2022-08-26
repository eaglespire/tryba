<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Customdomain extends Model
{
    use HasFactory, UsesUuid;
    protected $table = "custom_domain";

    
    protected $fillable = [
        'domain',
        'status',
        'user_id',
        'cloudflare_id'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }    
}
