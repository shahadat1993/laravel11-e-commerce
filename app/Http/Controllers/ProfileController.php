<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        // ভ্যালিডেশন
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'old_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        // ১. নাম, ইমেইল এবং মোবাইল আপডেট
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;

        // ২. ইমেজ আপলোড লজিক
        if ($request->hasFile('image')) {
            // পুরাতন ইমেজ ডিলিট করা (যদি থাকে)
            if ($user->image) {
                $oldImagePath = public_path('uploads/profile/' . $user->image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('uploads/profile'), $imageName);
            $user->image = $imageName;
        }

        // ৩. পাসওয়ার্ড চেঞ্জ লজিক
        if ($request->filled('new_password')) {

        // চেক ১: ওল্ড পাসওয়ার্ড সঠিক কিনা
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'আপনার পুরাতন পাসওয়ার্ডটি সঠিক নয়!']);
        }

        // চেক ২: নিউ পাসওয়ার্ড এবং কনফার্ম পাসওয়ার্ড মিলছে কিনা
        if ($request->new_password !== $request->new_password_confirmation) {
            return back()->withErrors(['new_password' => 'নতুন পাসওয়ার্ড এবং কনফার্ম পাসওয়ার্ড মিলছে না!']);
        }

        // সব ঠিক থাকলে পাসওয়ার্ড সেট করা
        $user->password = Hash::make($request->new_password);
    }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}
