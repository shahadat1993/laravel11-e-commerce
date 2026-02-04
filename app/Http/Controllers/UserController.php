<?php

namespace App\Http\Controllers;

use id;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use SweetAlert2\Laravel\Swal;
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
            return view('user.order-details', compact('order', 'orderItems', 'transactions'));
        } else {
            return redirect()->route('login');
        }
    }

    // ORDER CANCEL METHOD
    public function order_cancel(Request $request)
    {;

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

    // Method for User Profile
    public function users()
    {
        $users = User::orderBy('created_at', 'DESC')->with('orders')->paginate(10);
        // UserController.php


        return view('admin.users', compact('users'));
    }



    // Users delete method
    public function delete_user($id)
    {
        User::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully!'
        ]);
    }


    // User order count method
    // UserController.php
    public function showOrders($id)
    {
        $user = User::with('orders')->findOrFail($id);

        return view('admin.user_orders', compact('user'));
    }


    // User address method
    public function address()
    {
        $addresses = Address::where('user_id', Auth::user()->id)->get();

        return view('user.address', compact('addresses'));
    }


    // Add address method
    public function user_add_address()
    {
        return view('user.addAddress');
    }

    // Store address method
    public function store_address(Request $request)
    {
        $user_id = Auth::id();

        $request->validate([
            'name'      => 'required|string|max:255',
            'phone'     => 'required|numeric',
            'zip'       => 'required|numeric',
            'city'      => 'required|string|max:100',
            'state'     => 'required|string|max:100',
            'address'   => 'required|string',
            'locality'  => 'required|string|max:100',
            'landmark'  => 'required|string|max:100',
        ]);

        // ❗ আগের default address গুলো reset করো
        Address::where('user_id', $user_id)->update(['isdefault' => false]);

        $address = new Address();
        $address->user_id   = $user_id;
        $address->name      = $request->name;
        $address->phone     = $request->phone;
        $address->zip       = $request->zip;
        $address->city      = $request->city;
        $address->state     = $request->state;
        $address->address   = $request->address;
        $address->locality  = $request->locality;
        $address->landmark  = $request->landmark;
        $address->country   = 'Bangladesh';
        $address->isdefault = true;
        $address->save();

        return redirect()->route('user.address')->with('success', 'Address added successfully');
    }

    // Set default address method
    public function setDefault($id)
    {
        $user_id = Auth::id();

        $address = Address::where('id', $id)
            ->where('user_id', $user_id)
            ->first();

        if (!$address) {
            return redirect()->back()->with('error', 'Invalid address');
        }

        // 1️⃣ সব address non-default
        Address::where('user_id', $user_id)
            ->update(['isdefault' => false]);

        // 2️⃣ এই address default
        $address->isdefault = true;
        $address->save();

        return redirect()->back()->with('success', 'Default address updated');
    }


    // Delete address method
    public function destroy($id)
    {
        $address = Address::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$address) {
            return response()->json([
            'success' => false,
            'message' => 'Address not found!'
        ]);
        }

        // default address delete করা হলে অন্যটা default করা (optional but smart)
        if ($address->isdefault) {
            Address::where('user_id', Auth::id())
                ->where('id', '!=', $id)
                ->first()?->update(['isdefault' => true]);
        }

        $address->delete();

       return response()->json([
            'success' => true,
            'message' => 'Address deleted successfully!'
        ]);
    }

    // USER ACCOUNT DETAILS
    public function account_details()
    {
        $users = User::where('id', Auth::user()->id)->first();
        return view('user.account_details', compact('users'));
    }
}
