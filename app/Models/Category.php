<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Str;

class Category extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'categories';

    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category_name',
        'slug',
        'icon',
        'description'
    ];

    public function products(){
        return $this->hasMany(Products::class,'category_id','category_id');
    }

    public function setCategoryNameAttribute($value){
        $this->attributes['category_name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
