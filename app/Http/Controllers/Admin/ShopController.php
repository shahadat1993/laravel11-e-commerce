<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    //INDEX METHOD
    public function index(Request $request)
    {
        $size = $request->query('size') ?? 12;
        $order = $request->query('order') ?? -1;
        $f_brands = $request->query('brands');
        $f_categories = $request->query('categories');
        $min_price=$request->query('min') ? $request->query('min') : 1;
        $max_price=$request->query('max') ? $request->query('max') : 5000;

        $o_column = "created_at";
        $o_order = "DESC";

        switch ($order) {
            case 1:
                $o_column = "created_at";
                $o_order = "ASC";
                break;
            case 2:
                $o_column = "created_at";
                $o_order = "DESC";
                break;
            case 3:
                // price low to high
                $o_column = "price";
                $o_order = "ASC";
                break;
            case 4:
                // price high to low
                $o_column = "price";
                $o_order = "DESC";
                break;
        }

        $brands=Brand::orderBy('name','ASC')->get();
        $categories=Category::orderBy('name','ASC')->get();

        // এখন ডেটাবেস থেকে price হিসেবে sort করবো
        if (in_array($order, [3, 4])) {
            $products = Product::select('*')
                ->selectRaw('COALESCE(sale_price, regular_price) as price')
                ->orderBy('price', $o_order)
                ->paginate($size);
        } else {
            $products = Product::where(function($query) use($f_brands){
                $query->whereIn('brand_id',explode(',',$f_brands))->orWhereRaw("'".$f_brands."' = ''");
            })
            ->where(function($query) use($f_categories){
                $query->whereIn('category_id',explode(',',$f_categories))->orWhereRaw("'".$f_categories."' = ''");
            })
            ->where(function($query) use($min_price,$max_price){
                $query->whereBetween('regular_price',[$min_price,$max_price])->orWhereBetween('sale_price',[$min_price,$max_price]);
            })
            ->orderBy($o_column, $o_order)->paginate($size);
        }

        return view('shop', compact('products', 'size', 'order','brands','f_brands','categories','f_categories','min_price','max_price'));
    }


    // PRODUCC DETAILS METHOD
    public function productDetails($slug)
    {
        $product = Product::where('slug', $slug)->first();
        $rProducts = Product::where('slug', '<>', $slug)->get()->take(8);
        return view('productDetails', compact('product', 'rProducts'));
    }
}
