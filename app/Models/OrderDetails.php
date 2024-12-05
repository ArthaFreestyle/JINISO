<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected $table = 'order_details';

    protected $primaryKey = 'order_detail_id';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'subtotal',
        'product_size_id'
    ];

    public function order(){
        return $this->belongsTo(Orders::class,'order_id','order_id');
    }

    public function product(){
        return $this->belongsTo(Products::class,'product_id','product_id');
    }

    public function size(){
        return $this->belongsTo(ProductSize::class,'product_size_id','id');
    }
}
