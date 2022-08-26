<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplianceAudit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reason',
        'response',
        'file_url',
        'responded',
        'url',
        'privateNote',
        'isSuspended'
    ];

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
