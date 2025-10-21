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
                <h3>Brand infomation</h3>
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
                        <a href="{{ route('admin.brands') }}">
                            <div class="text-tiny">Brands</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">New Brand</div>
                    </li>
                </ul>
            </div>
            <!-- new-category -->
            <div class="wg-box">
                <form class="form-new-product form-style-1" action="{{ route('admin.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <fieldset class="name">
                        <div class="body-title">Brand Name <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Brand name" name="brand_name" tabindex="0"
                            value="{{ old('brand_name') }}" aria-required="true" required="">
                    </fieldset>
                    @error('brand_name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <fieldset class="name">
                        <div class="body-title">Brand Slug <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Brand Slug" name="brand_slug" tabindex="0"
                            value="{{ old('brand_slug') }}" aria-required="true" required="">
                    </fieldset>
                    @error('brand_slug')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <fieldset>
                        <div class="body-title">Upload images <span class="tf-color-1">*</span>
                        </div>
                        <div class="upload-image flex-grow">
                            <div class="item" id="imgpreview" style="display:none">
                                <img src="upload-1.html" class="effect8" alt="">
                            </div>
                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Drop your images here or select <span class="tf-color">click to
                                            browse</span></span>
                                    <input type="file" id="myFile" name="brand_image" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    @error('brand_image')
                        <p class="text-danger">{{ $message }}</p>
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
            const brandNameInput = document.querySelector('input[name="brand_name"]');
            const brandSlugInput = document.querySelector('input[name="brand_slug"]');


            brandNameInput.addEventListener("input", function() {
                const nameValue = brandNameInput.value.trim();
                const slug = nameValue
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                brandSlugInput.value = slug;
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
