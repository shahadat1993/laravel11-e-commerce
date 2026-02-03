<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class WishListController extends Controller
{
    // INDEX METHOD
    public function index(){
        $items=Cart::instance('wishlist')->content();
        return view('wishlist',compact('items'));
    }

    //ADD_TO_WISHLIST MEHTOD
    public function add_to_wishlist(Request $request){
        Cart::instance('wishlist')->add(
            $request->id,
            $request->name,
            $request->quantity,
            $request->price,
        )->associate(\App\Models\Product::class);

        return redirect()->back();
    }

    // REMOVE FROM WISHLIST METHOD
    public function remove_wishlist($rowId){
        Cart::instance('wishlist')->remove($rowId);
        return redirect()->back();
    }

    // EMPTY WISHLIST
    public function empty_wishlist(){
        Cart::instance('wishlist')->destroy();
        return redirect()->back();
    }

    // MOVE_TO_CART METHOD
    public function move_to_cart($rowId){
        $item =Cart::instance('wishlist')->get($rowId);
        Cart::instance("wishlist")->remove($rowId);
        Cart::instance('cart')->add($item->id,$item->name,$item->qty,$item->price)->associate(\App\Models\Product::class);
        return redirect()->back();
    }


    // USER WISHLIST SHOW METHOD
    public function userWishlist()
    {
        $items = Cart::instance('wishlist')->content();
        return view('user.wishlist', compact('items'));
    }
}
