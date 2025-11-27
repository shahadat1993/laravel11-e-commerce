<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
   //order model
  public function order()
{
    return $this->belongsTo(Order::class, 'order_id');
}

}
