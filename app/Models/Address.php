<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id', 'name', 'phone', 'zip', 'city',
        'state', 'address', 'locality', 'landmark',
        'country', 'isdefault'
    ];
}
