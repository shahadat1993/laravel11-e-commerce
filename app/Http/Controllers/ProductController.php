<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //INDEX METHOD
    public function index()
    {
        // eager load category and brand
        $products = Product::with('category', 'brand')
            ->orderBy('created_at', 'DESC')
            ->paginate(6);

        return view('admin.products.index', compact('products'));
    }

    //ADD PRODUCT METHOD
    public function addProduct()
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();


        return view('admin.products.addProduct', compact('categories', 'brands'));
    }
    // PRODUCT STORE METHOD
    // PRODUCT STORE METHOD
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:100|unique:products,slug',
            'short_description' => 'nullable|string|max:255',
            'description' => 'required|string',
            'regular_price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'SKU' => 'required|string|unique:products,sku',
            'quantity' => 'required|integer|min:0',
            'stock_status' => 'required|in:instock,outofstock',
            'featured' => 'required|boolean',
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->slug);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->sku = $request->SKU;
        $product->quantity = $request->quantity;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        // Single Image Upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $imageName);
            $product->image = $imageName;
        }

        // Multiple Gallery Images Upload
        if ($request->hasFile('images')) {
            $galleryImages = [];
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . Str::random(5) . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/products'), $imageName);
                $galleryImages[] = $imageName;
            }
            // Store as JSON in DB
            $product->images = json_encode($galleryImages);
        }

        $product->save();

        return redirect()->route('admin.product.index')->with('success', 'Product added successfully!');
    }

    // EDIT PRODUCT METHOD
    public function editProduct($id){
        $product=Product::findOrFail($id);
         $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.products.editProduct',compact('product','categories','brands'));
    }

    // PRODUCT UPDATE METHOD
  public function updateProduct(Request $request){
    $request->validate([
        'name' => 'required|string|max:100',
        'slug' => 'required|string|max:100|unique:products,slug,'.$request->id,
        'short_description' => 'nullable|string|max:255',
        'description' => 'required|string',
        'regular_price' => 'required|numeric',
        'sale_price' => 'nullable|numeric',
        'SKU' => 'required|string|unique:products,sku,'.$request->id,
        'quantity' => 'required|integer|min:0',
        'stock_status' => 'required|in:instock,outofstock',
        'featured' => 'required|boolean',
        'category_id' => 'nullable|exists:categories,id',
        'brand_id' => 'nullable|exists:brands,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    $product = Product::findOrFail($request->id);
    $product->name = $request->name;
    $product->slug = Str::slug($request->slug);
    $product->short_description = $request->short_description;
    $product->description = $request->description;
    $product->regular_price = $request->regular_price;
    $product->sale_price = $request->sale_price;
    $product->sku = $request->SKU;
    $product->quantity = $request->quantity;
    $product->stock_status = $request->stock_status;
    $product->featured = $request->featured;
    $product->category_id = $request->category_id;
    $product->brand_id = $request->brand_id;

    // Single Image Upload (পুরোনো image unlink সহ)
    if ($request->hasFile('image')) {
       
        if ($product->image && file_exists(public_path('uploads/products/'.$product->image))) {
            unlink(public_path('uploads/products/'.$product->image));
        }

        $image = $request->file('image');
        $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/products'), $imageName);
        $product->image = $imageName;
    }

    // Multiple Gallery Images Upload (পুরোনো images unlink সহ)
    if ($request->hasFile('images')) {
        // পুরোনো gallery images unlink করা
        if ($product->images) {
            $oldImages = json_decode($product->images, true);
            if ($oldImages) {
                foreach ($oldImages as $oldImage) {
                    if (file_exists(public_path('uploads/products/'.$oldImage))) {
                        unlink(public_path('uploads/products/'.$oldImage));
                    }
                }
            }
        }

        $galleryImages = [];
        foreach ($request->file('images') as $image) {
            $imageName = time() . '_' . Str::random(5) . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $imageName);
            $galleryImages[] = $imageName;
        }
        $product->images = json_encode($galleryImages);
    }

    $product->save();

    return redirect()->route('admin.product.index')->with('success', 'Product updated successfully!');
}

// DELETE PRODUCT METHOD    
public function destroyProduct($id){
    $product = Product::findOrFail($id);

    // Single image delete
    if ($product->image) {
        $imagePath = public_path('uploads/products/' . $product->image);
        if (file_exists($imagePath)) {
            @unlink($imagePath);
        }
    }

    // Gallery images delete
    if ($product->images) {
        $galleryImages = json_decode($product->images, true);
        if ($galleryImages) {
            foreach ($galleryImages as $img) {
                $imgPath = public_path('uploads/products/' . $img);
                if (file_exists($imgPath)) {
                    @unlink($imgPath);
                }
            }
        }
    }

    $product->delete();

    // Return JSON instead of redirect
    return response()->json(['message' => 'Product deleted successfully!']);
}



 
}
