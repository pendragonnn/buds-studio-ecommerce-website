<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'description',
        'price',
        'stock',
        'image_url'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function testimonies()
    {
        return $this->hasManyThrough(Testimony::class, OrderDetail::class);
    }
}

