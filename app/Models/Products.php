<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Str;

class Products extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'products';

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'slug',
        'thumbnail',
        'description',
        'price',
        'stock',
        'isPopular',
        'category_id'
    ];

    public function setProductNameAttribute($value){
        $this->attributes['product_name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function images(){
        return $this->hasMany(ProductImage::class,'product_id');
    }

    public function sizes(){
        return $this->hasMany(ProductSize::class,'product_id');
    }

    public function review(){
        return $this->hasMany(ProductReviews::class);
    }
}
