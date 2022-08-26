<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()  {
        parent::boot();
        static::creating(function ($post) {
            $post->{$post->getKeyName()} = (string) \Str::uuid();
        });
    }
  
    protected $fillable = [
        'user_id',
        'account_id',
        'type',
        'task_id',
        'pan',
        'expiry',
        'mtg_token',
        'status',
        'c_status',
        'c_id',
        'task_url',
        'reference',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'id');
    }
}
