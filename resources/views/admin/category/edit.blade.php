@extends('layouts.admin')
@section('content')
    @include('sweetalert2::index')
    @push('styles')
        <style>
            #imgpreview img {
                width: 100%;
                height: 300px;
                object-fit: cover;
                border-radius: 8px;
                border: 2px solid #ddd;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }
        </style>
    @endpush
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Category infomation</h3>
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
                        <a href="{{ route('admin.category.index') }}">
                            <div class="text-tiny">Categories</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Edit Category</div>
                    </li>
                </ul>
            </div>
            <!-- new-category -->
            <div class="wg-box">
                <form class="form-new-product form-style-1" action="{{ route('admin.category.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <input type="hidden" name="id" value="{{ $category->id }}">
                    <fieldset class="name">
                        <div class="body-title">Category Name <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Category name" name="category_name" tabindex="0"
                            value="{{ $category->name }}" aria-required="true" required="">
                    </fieldset>
                    @error('category_name')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror
                    <fieldset class="name">
                        <div class="body-title">Category Slug <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Category Slug" name="category_slug" tabindex="0"
                            value="{{ $category->slug }}" aria-required="true" required="">
                    </fieldset>
                    @error('category_slug')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror
                    <fieldset>
                        <div class="body-title">Upload images <span class="tf-color-1">*</span>
                        </div>
                        <div class="upload-image flex-grow">
                            @if ($category->image)
                                <div class="item" id="imgpreview"
                                    style="{{ $category->image ? 'display:block' : 'display:none' }}">
                                    <img src="{{ asset('uploads/categories/' . $category->image) }}" class="effect8"
                                        alt="">

                                </div>
                            @endif

                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Drop your images here or select <span class="tf-color">click to
                                            browse</span></span>
                                    <input type="file" id="myFile" name="category_image" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    @error('category_image')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <div class="bot">
                        <div></div>
                        <button class="tf-button w208" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Element select
            const categoryNameInput = document.querySelector('input[name="category_name"]');
            const categorySlugInput = document.querySelector('input[name="category_slug"]');


            categoryNameInput.addEventListener("input", function() {
                const nameValue = categoryNameInput.value.trim();
                const slug = nameValue
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                categorySlugInput.value = slug;
            });

        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fileInput = document.getElementById("myFile");
            const imgPreviewDiv = document.getElementById("imgpreview");
            const imgTag = imgPreviewDiv.querySelector("img");

            fileInput.addEventListener("change", function(event) {
                const file = event.target.files[0]; // selected file

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        imgTag.src = e.target.result; // image show
                        imgPreviewDiv.style.display = "block"; // show preview box
                    }

                    reader.readAsDataURL(file);
                } else {
                    imgTag.src = "";
                    imgPreviewDiv.style.display = "none"; // hide if no file
                }
            });
        });
    </script>
@endpush
