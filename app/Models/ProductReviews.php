<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductReviews extends Model
{
    use HasFactory;
    protected $table = 'product_reviews';

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'review'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'product_id');
    }
}
