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
use Illuminate\Support\Facades\Hash;

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

        return redirect()->back()->with('success', 'Order canceled successfully');
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
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $user->delete();

        return response()->json([
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
            'phone' => 'required|string|max:15',
            'zip'   => 'required|string|max:10',
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

    // Edit User Addresses
    public function edit_address($id)
    {
        $address = Address::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('user.editAddress', compact('address'));
    }

    // Update User Address
    public function update_address(Request $request, $id)
    {
        $address = Address::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $request->validate([
            'name'      => 'required|string|max:255',
            'phone'     => 'required|string|max:15',
            'zip'       => 'required|string|max:10',
            'city'      => 'required|string|max:100',
            'state'     => 'required|string|max:100',
            'address'   => 'required|string',
            'locality'  => 'required|string|max:100',
            'landmark'  => 'required|string|max:100',
        ]);

        $address->update($request->only([
            'name',
            'phone',
            'zip',
            'city',
            'state',
            'address',
            'locality',
            'landmark'
        ]) + ['country' => 'Bangladesh']);

        return redirect()->route('user.address')->with('success', 'Address Updated Successfully!');
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
        $deleted = Address::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        if ($deleted === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found or not deleted'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Address deleted successfully!'
        ]);
    }




    // USER ACCOUNT DETAILS

    public function account_details()
    {
        $user = Auth::user();
        return view('user.account_details', compact('user'));
    }

    public function account_update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'old_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        // Profile Image Upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('uploads/users'), $imageName);
            $user->image = $imageName;
        }

        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;

        // Password Update
        if ($request->filled('new_password')) {
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
            } else {
                return back()->withErrors(['old_password' => 'Old password does not match!']);
            }
        }

        $user->save();

        return back()->with('success', 'Account updated successfully!');
    }


    // About US Method
    public function about()
    {
        return view('user.about');
    }
}
