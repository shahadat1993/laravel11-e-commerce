<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use SweetAlert2\Laravel\Swal;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    // CATEGORY INDEX
    public function index()
    {
        $categories = Category::orderBy('id', 'DESC')->paginate(6);
        return view('admin.category.index', compact('categories'));
    }

    // CATEGORY ADD
    public function add()
    {
        return view('admin.category.add');
    }

    // CATEGORY STORE
    public function store(Request $request)
    {
        // 🔹 Step 1: Validate the input
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_slug' => 'nullable|string|unique:categories,slug',
            'category_image' => 'nullable|image|mimes:jpg,jpeg,webp,png|max:2048',
        ]);

        // 🔹 Step 2: Create new Brand
        $category = new Category;
        $category->name = $request->category_name;
        $category->slug = $request->category_slug
            ? Str::slug($request->category_slug)
            : Str::slug($request->category_name);

        // 🔹 Step 3: Handle Image Upload
        if ($request->hasFile('category_image')) {
            $file = $request->file('category_image');
            $filename = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();

            // Move original image
            $file->move(public_path('uploads/categories'), $filename);
            $category->image = $filename;
        }

        // 🔹 Step 4: Save Brand
        $category->save();

        // 🔹 Step 5: Success Alert
        Swal::toastSuccess([
            'title' => 'Category Added Successfully!',
        ]);

        // 🔹 Step 6: Redirect
        // return back();
        return redirect()->route('admin.category.index');
    }

    // EDIT CATEGORY
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    // CATEGORY UPDATE
    public function update(Request $request)
    {
        // 🔹 Step 1: Validate the input
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_slug' => 'nullable|string|unique:categories,slug,' . $request->id,
            'category_image' => 'nullable|image|mimes:jpg,jpeg,webp,png|max:2048',
        ]);

        $category = Category::findOrFail($request->id);

        $category->name = $request->category_name;
        $category->slug = $request->category_slug
            ? Str::slug($request->category_slug)
            : Str::slug($request->category_name);

        // Delete Old Image
        if ($request->hasFile('category_image')) {
            // পুরনো image delete করো (যদি থাকে)
            if ($category->image && file_exists(public_path('uploads/categories/' . $category->image))) {
                unlink(public_path('uploads/categories/' . $category->image));
            }

            $file = $request->file('category_image');
            $filename = time() . '.' . $file->getClientOriginalName();
            $file->move(public_path('uploads/categories'), $filename);
            $category->image = $filename;
        }

        // 🔹 Step 4: Save Brand
        $category->save();

        // 🔹 Step 5: Success Alert
        Swal::toastSuccess([
            'title' => 'Category Updated Successfully!',
        ]);

        // 🔹 Step 6: Redirect
        // return back();
        return redirect()->route('admin.category.index');
    }

    // CATEGORY DELETE METHOD
    public function destroy($id)
    {

        $category = Category::findOrFail($id);

        // যদি image থাকে, তাহলে public/uploads/brands থেকে ফাইল ডিলেট করো
        if ($category->image && file_exists(public_path('uploads/categories/' . $category->image))) {

            unlink(public_path('uploads/categories/' . $category->image));
        }

        // Delete the DB record
        $category->delete();

        // Optional: success alert (you used SweetAlert2)
        // ✅ AJAX response হলে JSON রিটার্ন করো
        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);
        }

        // ✅ Normal redirect (যদি AJAX না হয়)
        return redirect()->route('admin.category.index')->with('success', 'Category deleted successfully.');
    }

    // SHOW CATEGORY ON FRONTEND
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = $category->products;  // সব product

        return view('category-products', compact('category', 'products'));
    }
}
