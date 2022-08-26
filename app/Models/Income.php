<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Income extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'description',
        'date',
        'categoryID',
        'subcategoryID',
        'invoiceurl',
        'amount',
        'tranxRef'
    ];

    public function category()
    {
        return $this->hasOne(ExpenseCategory::class,'id','categoryID');
    } 

    public function subcategory()
    {
        return $this->hasOne(ExpenseSubcategory::class,'id','subcategoryID');
    } 
}
