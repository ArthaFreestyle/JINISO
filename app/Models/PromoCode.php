<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $table = 'promo_codes';

    protected $primaryKey = 'id';

    protected $fillable = [
        'discount_amount',
        'code'
    ];

    public function orders(){
        return $this->hasMany(Orders::class,'promo_code_id','id');
    }
}
