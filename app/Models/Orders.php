<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';

    protected $primaryKey = 'order_id';

    protected $fillable = [
        'user_id',
        'order_date',
        'total_amount',
        'promo_code_id',
        'status'
    ];

    public function details(){
        return $this->hasMany(OrderDetails::class,'order_id','order_id');
    }

    public function promo(){
        return $this->belongsTo(PromoCode::class,'promo_code_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
