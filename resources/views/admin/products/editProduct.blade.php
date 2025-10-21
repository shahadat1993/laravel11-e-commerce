@extends('layouts.admin')

@push('styles')
@endpush
@section('content')
    <!-- main-content-wrap -->
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Product</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="{{ route('admin.product.index') }}">
                            <div class="text-tiny">Products</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Edit product</div>
                    </li>
                </ul>
            </div>
            <!-- form-add-product -->
            <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data"
                action="{{ route('admin.product.update') }}">
                @csrf
                @method('put')
                <input type="hidden" name="id" value="{{ $product->id }}">
                <div class="wg-box">
                    <fieldset class="name">
                        <div class="body-title mb-10">Product name <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Enter product name" name="name" tabindex="0"
                            value="{{ $product->name }}" aria-required="true" required="">
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>

                    </fieldset>
                    @error('name')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror

                    <fieldset class="name">
                        <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter product slug" name="slug" tabindex="0"
                            value="{{ $product->slug }}" aria-required="true" required="">

                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                    </fieldset>
                    @error('slug')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror

                    <div class="gap22 cols">
                        <fieldset class="category">
                            <div class="body-title mb-10">Category <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select class="category" name="category_id">
                                    <option>--Select a category--</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>
                        @error('category_id')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                        @enderror

                        <fieldset class="brand">
                            <div class="body-title mb-10">Brand <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select class="brand" name="brand_id">
                                    <option>--Select a brand--</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>
                        @error('brand_id')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>


                    <fieldset class="shortdescription">
                        <div class="body-title mb-10">Short Description <span class="tf-color-1">*</span></div>
                        <textarea class="mb-10 ht-150" name="short_description" placeholder="Short Description" tabindex="0"
                            aria-required="true" required="">{{ $product->short_description }}</textarea>
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                    </fieldset>
                    @error('short_description')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror

                    <fieldset class="description">
                        <div class="body-title mb-10">Description <span class="tf-color-1">*</span>
                        </div>
                        <textarea class="mb-10" name="description" placeholder="Description" tabindex="0" aria-required="true"
                            required="">{{ $product->description }}</textarea>
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                    </fieldset>
                    @error('description')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="wg-box">
                    <fieldset>
                        <div class="body-title">Upload Main Image <span class="tf-color-1">*</span></div>
                        <div class="upload-image flex-grow">
                            <div class="item" id="imgpreview" style="display: {{ $product->image ? 'block' : 'none' }}">
                                <img src="{{ $product->image ? asset('uploads/products/' . $product->image) : '' }}"
                                    class="effect8" alt="Product Image"
                                    style="width:100%; max-height:300px; object-fit:cover;">
                            </div>


                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Drop your image here or select <span class="tf-color">click to
                                            browse</span></span>
                                    <input type="file" id="myFile" name="image" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    @error('image')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror

                    <fieldset>
                        <div class="body-title mb-10">Upload Gallery Images</div>
                        <div class="upload-image mb-16" id="galleryPreviewContainer">
                            <div id="galUpload" class="item up-load">
                                <label class="uploadfile" for="gFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="text-tiny">Drop your images here or select <span class="tf-color">click
                                            to browse</span></span>
                                    <input type="file" id="gFile" name="images[]" accept="image/*" multiple>
                                </label>
                            </div>
                            <div id="galleryPreview" class="flex flex-wrap gap-2 mt-2">
                                @if ($product->images)
                                    @foreach (json_decode($product->images) as $img)
                                        <img src="{{ asset('uploads/products/' . $img) }}"
                                            style="width:80px; height:80px; object-fit:cover;"
                                            class="rounded old-gallery-img">
                                    @endforeach
                                @endif


                            </div>


                        </div>
                    </fieldset>
                    @error('images')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Regular Price <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Enter regular price" name="regular_price"
                                tabindex="0" value="{{ $product->regular_price }}" aria-required="true"
                                required="">
                        </fieldset>
                        @error('regular_price')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                        <fieldset class="name">
                            <div class="body-title mb-10">Sale Price <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Enter sale price" name="sale_price"
                                tabindex="0" value="{{ $product->sale_price }}" aria-required="true" required="">
                        </fieldset>
                        @error('sale_price')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>


                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">SKU <span class="tf-color-1">*</span>
                            </div>
                            <input class="mb-10" type="text" placeholder="Enter SKU" name="SKU" tabindex="0"
                                value="{{ $product->sku }}" aria-required="true" required="">
                        </fieldset>
                        @error('SKU')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                        <fieldset class="name">
                            <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span>
                            </div>
                            <input class="mb-10" type="text" placeholder="Enter quantity" name="quantity"
                                tabindex="0" value="{{ $product->quantity }}" aria-required="true" required="">
                        </fieldset>
                        @error('quantity')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Stock</div>
                            <div class="select mb-10">
                                <select class="" name="stock_status">
                                    <option value="instock" {{ $product->stock_status == 'instock' ? 'selected' : '' }}>
                                        InStock</option>
                                    <option value="outofstock"
                                        {{ $product->stock_status == 'outofstock' ? 'selected' : '' }}>Out of Stock
                                    </option>
                                </select>
                            </div>
                        </fieldset>
                        @error('stock_status')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                        <fieldset class="name">
                            <div class="body-title mb-10">Featured</div>
                            <div class="select mb-10">
                                <select class="" name="featured">
                                    <option value="0" {{ $product->stock_status == 0 ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ $product->stock_status == 1 ? 'selected' : '' }}>Yes
                                    </option>
                                </select>
                            </div>
                        </fieldset>
                        @error('featured')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="cols gap10">
                        <button class="tf-button w-full" type="submit">Update product</button>
                    </div>
                </div>
            </form>
            <!-- /form-add-product -->
        </div>
        <!-- /main-content-wrap -->
    </div>
    <!-- /main-content-wrap -->
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // --- Single Image Preview ---
            const singleInput = document.getElementById('myFile');
            const imgPreview = document.getElementById('imgpreview');
            const imgTag = imgPreview ? imgPreview.querySelector('img') : null;

            // যদি database থেকে পুরনো image থাকে, তাহলে সেটি দেখাও
            @if ($product->image)
                imgPreview.style.display = 'block';
                imgTag.src = "{{ asset('uploads/products/' . $product->image) }}";
            @endif

            if (singleInput && imgPreview && imgTag) {
                singleInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            imgTag.src = event.target.result;
                            imgPreview.style.display = 'block';
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }

            // --- Multiple Gallery Images Preview ---
            const galleryInput = document.getElementById('gFile');
            const galleryPreview = document.getElementById('galleryPreview');

            if (galleryInput && galleryPreview) {
                galleryInput.addEventListener('input', function(e) {
                    const files = e.target.files;
                    galleryPreview.innerHTML = '';

                    if (files.length > 0) {
                        Array.from(files).forEach(file => {
                            const reader = new FileReader();
                            reader.onload = function(event) {
                                const img = document.createElement('img');
                                img.src = event.target.result;
                                img.style.width = '80px';
                                img.style.height = '80px';
                                img.style.objectFit = 'cover';
                                img.classList.add('rounded');
                                galleryPreview.appendChild(img);
                            };
                            reader.readAsDataURL(file);
                        });
                    }
                });
            }


            // --- Auto Slug from Product Name ---
            const nameInput = document.querySelector('input[name="name"]');
            const slugInput = document.querySelector('input[name="slug"]');

            if (nameInput && slugInput) {
                nameInput.addEventListener('input', function() {
                    let slug = nameInput.value
                        .toLowerCase()
                        .trim()
                        .replace(/[^a-z0-9\s-]/g, '') // Remove special chars
                        .replace(/\s+/g, '-') // Space to dash
                        .replace(/-+/g, '-'); // Multiple dash to single dash
                    slugInput.value = slug;
                });
            }

        });
    </script>
@endpush
