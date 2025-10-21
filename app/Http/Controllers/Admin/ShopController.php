<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    //INDEX METHOD
    public function index(){
        $products=Product::orderBy('created_at','DESC')->paginate(3);

        return view('shop',compact('products'));
    }

    // PRODUCC DETAILS METHOD
        public function productDetails($slug){            
            $product=Product::where('slug',$slug)->first();
            $rProducts=Product::where('slug','<>',$slug)->get()->take(8);
            return view('productDetails',compact('product','rProducts'));
        }
}
