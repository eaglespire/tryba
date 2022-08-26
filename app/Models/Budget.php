<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'uuid',
        'month',
        'description',
        'year',
        'categoryID',
         'amount',
         'subcategoryID'
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
