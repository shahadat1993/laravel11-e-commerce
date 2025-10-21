<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SweetAlert2\Laravel\Swal;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function brands()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(5);

        return view('admin.brands', compact('brands'));
    }

    public function addBrand()
    {
        // dd('add brand route working');
        return view('admin.add-brand');
    }

    // STORE BRAND
    public function store_brand(Request $request)
    {
        // 🔹 Step 1: Validate the input
        $request->validate([
            'brand_name' => 'required|string|max:255',
            'brand_slug' => 'nullable|string|unique:brands,slug',
            'brand_image' => 'nullable|image|mimes:jpg,jpeg,webp,png|max:2048',
        ]);

        // 🔹 Step 2: Create new Brand
        $brand = new Brand;
        $brand->name = $request->brand_name;
        $brand->slug = $request->brand_slug
            ? Str::slug($request->brand_slug)
            : Str::slug($request->brand_name);

        // 🔹 Step 3: Handle Image Upload
        if ($request->hasFile('brand_image')) {
            $file = $request->file('brand_image');
            $filename = time().rand(1000, 9999).'.'.$file->getClientOriginalExtension();

            // Move original image
            $file->move(public_path('uploads/brands'), $filename);
            $brand->image = $filename;

        }

        // 🔹 Step 4: Save Brand
        $brand->save();

        // 🔹 Step 5: Success Alert
        Swal::toastSuccess([
            'title' => 'Brand Added Successfully!',
        ]);

        // 🔹 Step 6: Redirect
        // return back();
        return redirect()->route('admin.brands');
    }

    // edit
    public function edit_brand($id)
    {
        $brand = Brand::findOrFail($id);

        return view('admin.edit_brand', compact('brand'));
    }

    // UPADATE BRAND
    public function update_brand(Request $request)
    {

        // 🔹 Step 1: Validate the input
        $request->validate([
            'brand_name' => 'required|string|max:255',
            'brand_slug' => 'nullable|string|unique:brands,slug,'.$request->id,
            'brand_image' => 'nullable|image|mimes:jpg,jpeg,webp,png|max:2048',
        ]);

        $brand = Brand::findOrFail($request->id);

        $brand->name = $request->brand_name;
        $brand->slug = $request->brand_slug
            ? Str::slug($request->brand_slug)
            : Str::slug($request->brand_name);

        // Delete Old Image
        if ($request->hasFile('brand_image')) {
            // পুরনো image delete করো (যদি থাকে)
            if ($brand->image && file_exists(public_path('uploads/brands/'.$brand->image))) {
                unlink(public_path('uploads/brands/'.$brand->image));
            }

            $file = $request->file('brand_image');
            $filename = time().'.'.$file->getClientOriginalName();
            $file->move(public_path('uploads/brands'), $filename);
            $brand->image = $filename;
        }

        // 🔹 Step 4: Save Brand
        $brand->save();

        // 🔹 Step 5: Success Alert
        Swal::toastSuccess([
            'title' => 'Brand Updated Successfully!',
        ]);

        // 🔹 Step 6: Redirect
        // return back();
        return redirect()->route('admin.brands');
    }

    // Delete brand
    public function destroy_brand($id)
    {
       
        $brand = Brand::findOrFail($id);

        // যদি image থাকে, তাহলে public/uploads/brands থেকে ফাইল ডিলেট করো
        if ($brand->image && file_exists(public_path('uploads/brands/'.$brand->image))) {

            unlink(public_path('uploads/brands/'.$brand->image));
        }

        // Delete the DB record
        $brand->delete();

        // Optional: success alert (you used SweetAlert2)
        // ✅ AJAX response হলে JSON রিটার্ন করো
        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Brand deleted successfully.']);
        }

        // ✅ Normal redirect (যদি AJAX না হয়)
        return redirect()->route('admin.brands')->with('success', 'Brand deleted successfully.');
    }
}
