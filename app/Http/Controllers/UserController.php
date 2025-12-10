<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use SweetAlert2\Laravel\Swal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
            return view('user.order-details', compact('order', 'orderItems', 'transactions'));
        } else {
            return redirect()->route('login');
        }
    }

    // ORDER CANCEL METHOD
public function order_cancel(Request $request)
{
   ;

    $order = Order::find($request->order_id);

    if (!$order) {
        return response()->json([
            'success' => false,
            'message' => 'Order not found'
        ]);
    }

    if ($order->status == 'canceled') {
        return response()->json([
            'success' => false,
            'message' => 'Order already canceled'
        ]);
    }

    $order->status = 'canceled';
    $order->canceled_date = now();
    $order->save();

    return response()->json([
        'success' => true,
        'message' => 'Order canceled successfully'
    ]);
}



}
