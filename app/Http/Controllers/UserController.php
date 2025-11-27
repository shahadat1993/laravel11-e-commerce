<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    //ORDERS METHOD
    public function orders()
    {
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(6);
        return view('user.orders', compact('orders'));
    }

    // ORDER DETAILS METHOD
    public function order_details($order_id)
    {
        $order = Order::where('user_id', Auth::user()->id)->where('id', $order_id)->first();
        if ($order) {
            $orderItems = OrderItem::where('order_id', $order_id)->orderBy('id')->paginate(6);
            $transactions = Transaction::where('order_id', $order_id)->first();
            return view('user.order-details', compact('order', 'orderItems','transactions'));
        } else{
            return redirect()->route('login');
        }
    }
}
