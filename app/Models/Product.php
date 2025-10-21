<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Category releation
    public function category(){
        return $this->belongsTo(Category::class,"category_id");
    }
    // Brand releation
    public function brand(){
        return $this->belongsTo(Brand::class,"brand_id");
    }
}
