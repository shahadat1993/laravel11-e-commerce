<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Coupons;
use App\Models\Product;
use Illuminate\Http\Request;
use SweetAlert2\Laravel\Swal;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index()
    {
        // কার্টে থাকা সব আইটেম নাও
        $items = Cart::instance('cart')->content();

        // এখন view এ পাঠাও (cart-page দেখানোর জন্য)
        // dd($items);
        return view('cart', compact('items'));
    }


    // ADD TO CART METHOD
    public function addToCart(Request $request)
    {
        // Validate input
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        // Product fetch করা
        $product = Product::find($request->product_id);

        // Quantity set (default 1)
        $qty = $request->quantity ?? 1;

        // যদি sale price থাকে, তাহলে ওটাই নেবে, না থাকলে regular price নেবে
        $price = $product->sale_price ?? $product->regular_price;

        // Cart এ যোগ করা
        Cart::instance('cart')->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $qty,
            'price' => $price,
            'weight' => 0,
            'options' => [
                'image' => $product->image,
                'color' => $product->color ?? 'Default',
                'size' => $product->size ?? 'Default'
            ]
        ])->associate(\App\Models\Product::class);

        return redirect()->back()->with('success', $product->name . ' added to cart!');
    }

    // INCREASE QUANTITY OF CART ITEM
    public function increase_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back()->with('success', 'Product quantity increased!');
    }


    // DECREASE QUANTITY OF CART ITEM
    public function decrease_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;
        if ($qty < 1) {
            return redirect()->back()->with('error', 'Quantity cannot be less than 1!');
        }
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back()->with('success', 'Product quantity decreased!');
    }
    // REMOVE CART ITEM
    public function remove_cart_item($rowId)
    {
        Cart::instance('cart')->remove($rowId);
        return redirect()->back()->with('success', 'Product removed from cart!');
    }

    // CLEAR ALL CART ITEMS
    public function clear_cart()
    {
        Cart::instance('cart')->destroy();
        return redirect()->back()->with('success', 'Product removed from cart!');
    }


    // APPLY COUPON CODE
    public function apply_coupon_code(Request $request)
    {
        $coupon_code = $request->coupon_code;

        if (!$coupon_code) {
            Swal::fire([
                'title' => 'CodeNest Agency',
                'text' => 'Please enter a valid coupon code.',
                'icon' => 'error',
                'confirmButtonText' => 'ok'
            ]);
            return redirect()->back();
        }

        $subtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());

        $coupon = Coupons::where('code', $coupon_code)
            ->where('expiry_date', '>=', Carbon::today())
            ->where('cart_value', '<=', $subtotal)
            ->first();

        if (!$coupon) {
            Swal::fire([
                'title' => 'CodeNest Agency',
                'text' => 'Invalid or expired coupon code!',
                'icon' => 'error',
                'confirmButtonText' => 'ok'
            ]);
            return redirect()->back();
        }


        Session::put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'cart_value' => $coupon->cart_value,
        ]);
        $this->calculatedMethod();
        Swal::fire([
            'title' => 'CodeNest Agency',
            'text' => 'Coupon applied successfully!',
            'icon' => 'success',
            'confirmButtonText' => 'ok'
        ]);

        return redirect()->back();
    }

    // CALCULATED METHOD FOR COUPONS
  public function calculatedMethod()
{
    $discount = 0;

    if (Session::has('coupon')) {

        
        $subtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
        $coupon = Session::get('coupon');

      
        if ($coupon['type'] == 'fixed') {
            $discount = (float) $coupon['value'];
        } else {
            $discount = ($subtotal * (float) $coupon['value']) / 100;
        }

       
        $subTotalAfterDiscount = $subtotal - $discount;
        $taxRate = (float) config('cart.tax');
        $taxAfterDiscount = ($subTotalAfterDiscount * $taxRate) / 100;
        $totalAfterDiscount = $subTotalAfterDiscount + $taxAfterDiscount;

       
        Session::put('discounts',[
            'discount' => number_format($discount, 2, '.', ''),
            'subtotal' => number_format($subTotalAfterDiscount, 2, '.', ''),
            'tax' => number_format($taxAfterDiscount, 2, '.', ''),
            'total' => number_format($totalAfterDiscount, 2, '.', ''),
        ]);
    }
}


}
