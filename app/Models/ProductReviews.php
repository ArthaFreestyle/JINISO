<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReviews extends Model
{
    protected $table = 'product_reviews';

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'review'
    ];
}
