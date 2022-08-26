<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class BankingBeneficiary extends Model
{
    use HasFactory, UsesUuid;

    protected $table = 'banking_beneficiaries';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;    

    protected $fillable = [
        'user_id',
        'accountId',
        'accountNumber',
        'iban',
        'sortCode',
        'currency',
        'type',
        'email',
        'name',
        'dob',
        'country',
        'postCode',
        'postTown',
        'addressLine1',
        'addressLine2',
        'bic',
        'bid',
        'cid',
        'status',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'id');
    }
}
