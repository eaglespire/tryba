<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UsesUuid;

class Product extends Model
{
    use UsesUuid;
    use SoftDeletes;
    protected $table = "products";
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function bb()
    {
        return $this->belongsTo('App\Models\Currency', 'currency');
    }
    public function cat()
    {
        return $this->belongsTo('App\Models\Fundcategory', 'cat_id')->withTrashed();;
    }

    public function sum_review()
    {
        return Order::whereproduct_id($this->id)->sum('rating');
    }

    public function count_review()
    {
        return Order::whereproduct_id($this->id)->wherereview(!null)->count();
    }

    public function rating()
    {
        if ($this->count_review() == 0) {
            return $this->sum_review() / 1;
        } else {
            return $this->sum_review() / $this->count_review();
        }
    }
}
