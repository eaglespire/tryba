<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplianceDocument extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_name', 'file_path', 'user_id', 'status'
    ];

    public function user()  {
        return $this->belongsTo(User::class, 'id');
    }
}
