<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class BankingDetail extends Model
{
    use HasFactory, UsesUuid;

    protected $fillable = [
        'user_id',
        'applicantId',
        'companyName',
        'accountNumber',
        'sortCode',
        'accountType',
        'company_regNumber',
        'dob',
        'customerId',
        'status',
        'industryCode',
        'addressLin1',
        'addressLin2',
        'postCode',
        'postTown',
        'balance',
        'iban',
        'bic',
        'currency',
        'accountId',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
