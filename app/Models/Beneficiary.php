<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Beneficiary extends Model
{
    use HasFactory, UsesUuid;
    protected $fillable = [
        'user_id', 
        'ben_id'
    ];
    protected $table = "beneficiary";
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    } 
    public function to()
    {
        return $this->belongsTo('App\Models\User','ben_id');
    } 
}
