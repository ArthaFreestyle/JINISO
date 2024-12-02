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
        'subtotal'
    ];

    public function order(){
        return $this->belongsTo(Orders::class,'order_id','order_id');
    }

    public function product(){
        return $this->belongsTo(Products::class,'product_id','product_id');
    }
}
