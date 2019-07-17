<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id','name', 'description', 'price', 'category_id'
    ];

    public function category()
    {
        return $this->hasOne('App\Category', 'id', 'category_id');
    }
}
