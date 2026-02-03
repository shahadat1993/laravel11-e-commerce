<?php

namespace App\Http\Controllers;


use App\Mail\OrderPlacedMail;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Address;
use App\Models\Coupons;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use SweetAlert2\Laravel\Swal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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


            Session::put('discounts', [
                'discount' => number_format($discount, 2, '.', ''),
                'subtotal' => number_format($subTotalAfterDiscount, 2, '.', ''),
                'tax' => number_format($taxAfterDiscount, 2, '.', ''),
                'total' => number_format($totalAfterDiscount, 2, '.', ''),
            ]);
        }
    }

    // REMOVE_COUPON_CODE
    public function remove_coupon_code()
    {
        Session::forget('coupon');
        Session::forget('discounts');
        Swal::fire([
            'title' => 'CodeNest Agency',
            'text' => 'Coupon removed successfully!',
            'icon' => 'success',
            'confirmButtonText' => 'ok'
        ]);
        return redirect()->back();
    }

    // CHECKOUT FUNCTION
    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $address = Address::where('user_id', Auth::user()->id)->where('isdefault', 1)->first();
        return view('checkout', compact('address'));
    }

    // PLACE ORDER FUNCTION
    public function place_an_order(Request $request)
    {
        $user_id = Auth::user()->id;
        $address = Address::where('user_id', Auth::user()->id)->where('isdefault', true)->first();

        if (!$address) {
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|numeric',
                'zip' => 'required|numeric',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:100',
                'address' => 'required|string',
                'locality' => 'required|string|max:100',
                'landmark' => 'required|string|max:100',
            ]);



            $address = new Address();
            $address->name = $request->name;
            $address->phone = $request->phone;
            $address->zip = $request->zip;
            $address->city = $request->city;
            $address->state = $request->state;
            $address->address = $request->address;
            $address->locality = $request->locality;
            $address->landmark = $request->landmark;
            $address->country = '';
            $address->user_id = $user_id;
            $address->isdefault = true;
            $address->save();
        }

        $this->setAmountForCheckout();

        $order = new Order();
        $order->user_id = $user_id;
        $order->subtotal = floatval(str_replace(',', '', Session::get('checkout')['subtotal']));
        $order->discount = floatval(str_replace(',', '', Session::get('checkout')['discount']));
        $order->tax = floatval(str_replace(',', '', Session::get('checkout')['tax']));
        $order->total = floatval(str_replace(',', '', Session::get('checkout')['total']));
        $order->name = $address->name;
        $order->phone = $address->phone;
        $order->locality = $address->locality;
        $order->address = $address->address;
        $order->city = $address->city;
        $order->state = $address->state;
        $order->country = $address->country;
        $order->landmark = $address->landmark;
        $order->zip = $address->zip;
        $order->save();

        foreach (Cart::instance('cart')->content() as $item) {
            $orderItem = new OrderItem();
            $orderItem->product_id = $item->id;
            $orderItem->order_id = $order->id;
            $orderItem->price = $item->price;
            $orderItem->quantity = $item->qty;
            $orderItem->save();
        }
        if ($request->mode == 'card') {
            //
        } elseif ($request->mode == 'paypal') {
            //
        } elseif ($request->mode == 'cod') {
            $transaction = new Transaction();
            $transaction->user_id = $user_id;
            $transaction->order_id = $order->id;
            $transaction->mode = $request->mode;
            $transaction->status = 'pending';
            $transaction->save();
        }

        // ✅ EMAIL SEND
       Mail::to(Auth::user()->email)->send(new OrderPlacedMail($order));





        Cart::instance('cart')->destroy();
        Session::forget('checkout');
        Session::forget('coupon');
        Session::forget('discounts');
        Session::put('order_id', $order->id);
        Swal::fire([
            'title' => 'CodeNest Agency',
            'text' => 'Order placed successfully!',
            'icon' => 'success',
            'confirmButtonText' => 'ok'
        ]);
        return redirect()->route('cart.order-confirmation', compact('order'))->with('success', 'Order placed successfully!');
    }



    // SETAMOUNTFOR CHECKOUT METHOD
    public function setAmountForCheckout()
    {
        if (!Cart::instance('cart')->content()->count() > 0) {
            Session::forget('checkout');
            return;
        }

        if (Session::has('coupon')) {

            Session::put('checkout', [
                'discount' => Session::get('discounts')['discount'],
                'subtotal' => Session::get('discounts')['subtotal'],
                'tax' => Session::get('discounts')['tax'],
                'total' => Session::get('discounts')['total'],
            ]);
        } else {
            Session::put('checkout', [
                'discount' => 0,
                'subtotal' => Cart::instance('cart')->subtotal(),
                'tax' => Cart::instance('cart')->tax(),
                'total' => Cart::instance('cart')->total(),
            ]);
        }
    }

    // ORDER CONFIRMATION
    public function order_confirmation()
    {
        if (Session::has('order_id')) {

            $order_id = Session::get('order_id');

            $order = Order::with(['orderItems.product', 'transaction'])
                ->find($order_id);

            return view('order-confirmation', compact('order'));
        }

        Swal::fire([
            'title' => 'CodeNest Agency',
            'text' => 'Something went wrong!',
            'icon' => 'error',
            'confirmButtonText' => 'ok'
        ]);

        return redirect()->route('cart');
    }
}
