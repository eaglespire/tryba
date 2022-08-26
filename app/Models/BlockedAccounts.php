<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlockedAccounts extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'user_id', 
        'private_note',
        'isMoneyinAccount',
        'account_number',
        'sort_code',
        'slug'
    ];

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
