@extends('layouts.admin')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap');
        .main-content-inner { font-family: 'Plus Jakarta Sans', sans-serif; background: #f4f7fe; padding: 30px 20px; }
        h3 { font-size: 28px !important; font-weight: 800; color: #1e293b; }
        .text-tiny { font-size: 13px; color: #64748b; font-weight: 500; }
        .tf-section-2 { display: grid; grid-template-columns: 2fr 1.2fr; gap: 25px; align-items: start; }
        .wg-box { background: #ffffff; border-radius: 20px; padding: 30px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); border: 1px solid #eef2f6; margin-bottom: 25px; }
        .body-title { font-size: 15px; font-weight: 700; color: #334155; margin-bottom: 10px; }
        input[type="text"], textarea, select { width: 100%; padding: 14px 18px; border-radius: 12px; border: 1.5px solid #e2e8f0; background: #fff; font-size: 15px; font-weight: 500; color: #1e293b; transition: 0.3s ease; }
        input:focus, textarea:focus, select:focus { border-color: #4f46e5; box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1); outline: none; }
        .upload-image { border: 2px dashed #cbd5e1; border-radius: 15px; padding: 25px; background: #f8fafc; text-align: center; cursor: pointer; transition: 0.3s; }
        .preview-item { position: relative; display: inline-block; width: 110px; height: 110px; margin: 10px; border-radius: 12px; }
        .preview-item img { width: 100%; height: 100%; object-fit: cover; border-radius: 12px; border: 2px solid #fff; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08); }
        .delete-btn-icon { position: absolute; top: -10px; right: -10px; background: #ef4444; color: white; width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 2px solid #fff; font-size: 16px; }
        .btn-submit { background: #4f46e5; color: #fff; padding: 16px; border-radius: 15px; font-weight: 700; font-size: 17px; width: 100%; border: none; cursor: pointer; box-shadow: 0 10px 20px rgba(79, 70, 229, 0.2); }
        @media (max-width: 1024px) { .tf-section-2 { grid-template-columns: 1fr; } }
        .text-danger { color: #ef4444; font-size: 13px; margin-top: 5px; font-weight: 600; }
    </style>
@endpush

@section('content')
    <div class="main-content-inner">
        <div class="mb-8">
            <h3>Edit Product</h3>
            <p class="text-tiny">Update existing product information and media</p>
        </div>

        <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data" action="{{ route('admin.product.update') }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $product->id }}">

            <div class="left-content">
                <div class="wg-box">
                    <div class="mb-6">
                        <label class="body-title">Product Name <span class="text-red-500">*</span></label>
                        <input type="text" id="p_name" name="name" placeholder="Enter product name" value="{{ $product->name }}" oninput="generateSlug(this.value)" required>
                        @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="body-title">Slug <span class="text-red-500">*</span></label>
                        <input type="text" id="p_slug" name="slug" placeholder="product-slug" value="{{ $product->slug }}" required readonly class="bg-slate-100 cursor-not-allowed">
                        @error('slug') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="body-title">Category <span class="text-red-500">*</span></label>
                            <select name="category_id" required>
                                <option value="">--Select Category--</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="body-title">Brand <span class="text-red-500">*</span></label>
                            <select name="brand_id" required>
                                <option value="">--Select Brand--</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="body-title">Short Description</label>
                        <textarea name="short_description" rows="3">{{ $product->short_description }}</textarea>
                    </div>

                    <div class="mb-0">
                        <label class="body-title">Full Description</label>
                        <textarea name="description" rows="6">{{ $product->description }}</textarea>
                    </div>
                </div>
            </div>

            <div class="right-content">
                <div class="wg-box">
                    <label class="body-title">Main Thumbnail</label>
                    <div class="upload-image" onclick="document.getElementById('myFile').click()">
                        <i class="ri-upload-cloud-fill text-3xl text-indigo-500"></i>
                        <p class="text-tiny mt-2">Update main image</p>
                        <input type="file" id="myFile" name="image" accept="image/*" class="hidden">
                    </div>
                    <div id="mainPreviewContainer" class="mt-4 flex justify-center">
                        @if($product->image)
                            <div class="preview-item">
                                <img src="{{ asset('uploads/products/'.$product->image) }}">
                                <div class="delete-btn-icon" onclick="removeMainImg()"><i class="ri-close-line"></i></div>
                            </div>
                        @endif
                    </div>

                    <div class="mt-8">
                        <label class="body-title">Gallery Images</label>
                        <div class="upload-image" onclick="document.getElementById('gFile').click()">
                            <i class="ri-gallery-fill text-3xl text-slate-400"></i>
                            <p class="text-tiny mt-2">Add more gallery images</p>
                            <input type="file" id="gFile" name="images[]" accept="image/*" multiple class="hidden">
                        </div>
                        <div id="galleryPreviewContainer" class="flex flex-wrap gap-2 mt-4 justify-center">
                            @if ($product->images)
                                @foreach (json_decode($product->images) as $img)
                                    <div class="preview-item">
                                        <img src="{{ asset('uploads/products/' . $img) }}">
                                        <div class="delete-btn-icon" onclick="this.parentElement.remove()"><i class="ri-close-line"></i></div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="wg-box">
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="body-title">Regular Price</label>
                            <input type="text" name="regular_price" value="{{ $product->regular_price }}">
                        </div>
                        <div>
                            <label class="body-title">Sale Price</label>
                            <input type="text" name="sale_price" value="{{ $product->sale_price }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="body-title">SKU</label>
                            <input type="text" name="SKU" value="{{ $product->sku }}">
                        </div>
                        <div>
                            <label class="body-title">Quantity</label>
                            <input type="text" name="quantity" value="{{ $product->quantity }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="body-title">Stock</label>
                            <select name="stock_status">
                                <option value="instock" {{ $product->stock_status == 'instock' ? 'selected' : '' }}>In Stock</option>
                                <option value="outofstock" {{ $product->stock_status == 'outofstock' ? 'selected' : '' }}>Out of Stock</option>
                            </select>
                        </div>
                        <div>
                            <label class="body-title">Featured</label>
                            <select name="featured">
                                <option value="0" {{ $product->featured == 0 ? 'selected' : '' }}>No</option>
                                <option value="1" {{ $product->featured == 1 ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Update Product</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // স্লাগ জেনারেশন ফাংশন (অবশ্যই স্ক্রিপ্টের শুরুতে রাখবেন)
        function generateSlug(val) {
            let slug = val.toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');

            document.getElementById('p_slug').value = slug;
        }

        document.addEventListener("DOMContentLoaded", function() {
            // ১. মেইন ইমেজ প্রিভিউ
            const mainFile = document.getElementById('myFile');
            const mainContainer = document.getElementById('mainPreviewContainer');

            if (mainFile) {
                mainFile.addEventListener('change', function() {
                    mainContainer.innerHTML = "";
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            mainContainer.innerHTML = `
                                <div class="preview-item">
                                    <img src="${e.target.result}">
                                    <div class="delete-btn-icon" onclick="removeMainImg()"><i class="ri-close-line"></i></div>
                                </div>`;
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }

            window.removeMainImg = function() {
                document.getElementById('myFile').value = "";
                mainContainer.innerHTML = "";
            };

            // ২. গ্যালারি ইমেজ প্রিভিউ
            const galleryFile = document.getElementById('gFile');
            const galleryContainer = document.getElementById('galleryPreviewContainer');

            if (galleryFile) {
                galleryFile.addEventListener('change', function() {
                    const files = Array.from(this.files);
                    files.forEach((file) => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const div = document.createElement('div');
                            div.className = 'preview-item';
                            div.innerHTML = `
                                <img src="${e.target.result}">
                                <div class="delete-btn-icon" onclick="this.parentElement.remove()"><i class="ri-close-line"></i></div>
                            `;
                            galleryContainer.appendChild(div);
                        }
                        reader.readAsDataURL(file);
                    });
                });
            }
        });
    </script>
@endpush
