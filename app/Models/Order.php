<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //user model
    public function user(){
        $this->belongsTo(User::class);
    }
    //orderItems model
   public function orderItems()
{
    return $this->hasMany(OrderItem::class, 'order_id');
}

    //Transaction model
   public function transaction()
{
    return $this->hasOne(Transaction::class, 'order_id');
}

}
