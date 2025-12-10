<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use App\Models\Product;
use App\Models\Category;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class EcommerceController extends Controller
{
    public function index()
    {

        $slides = Slide::where('status', 1)->limit(3)->get();
        $categories =Category::orderBy('name')->get();
        $sproducts=Product::whereNotNull('sale_price')->where('sale_price','<>','')->inRandomOrder()->get()->take(8);
        $items=Cart::instance('wishlist')->content();
        return view('index',compact('slides','categories','sproducts','items'));
    }
}
