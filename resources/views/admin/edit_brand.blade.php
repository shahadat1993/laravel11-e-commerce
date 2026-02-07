@extends('layouts.admin')

@section('content')
    @include('sweetalert2::index')
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700;800&display=swap');

            .main-content-inner {
                font-family: 'Plus Jakarta Sans', sans-serif;
                background: #f4f7fa;
                padding: 60px 20px;
            }

            .form-container {
                max-width: 1100px;
                margin: 0 auto;
                background: #ffffff;
                border-radius: 40px;
                padding: 60px;
                box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.08);
                border: 1px solid #e2e8f0;
            }

            h3 {
                font-size: 42px !important;
                font-weight: 800;
                color: #0f172a;
                margin-bottom: 15px;
                letter-spacing: -1px;
            }

            .header-desc {
                font-size: 18px;
                color: #64748b;
                margin-bottom: 50px;
            }

            .body-title {
                font-size: 20px;
                font-weight: 800;
                color: #1e293b;
                margin-bottom: 15px;
                display: block;
                padding-left: 5px;
            }

            .custom-input {
                width: 100%;
                padding: 22px 30px;
                border-radius: 20px;
                border: 2px solid #e2e8f0;
                font-size: 19px;
                font-weight: 600;
                transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                background: #fbfcfd;
                color: #0f172a;
            }

            .custom-input:focus {
                border-color: #4f46e5;
                background: #fff;
                outline: none;
                box-shadow: 0 0 0 8px rgba(79, 70, 229, 0.08);
                transform: translateY(-2px);
            }

            .upload-zone {
                position: relative;
                width: 100%;
                min-height: 400px;
                background: #f8fafc;
                border: 4px dashed #cbd5e1;
                border-radius: 30px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                transition: 0.4s;
                overflow: hidden;
            }

            #imgpreview {
                width: 100%;
                height: 100%;
                position: absolute;
                top: 0; left: 0;
                z-index: 10;
            }

            #imgpreview img {
                width: 100%;
                height: 100%;
                object-fit: contain;
                background: #f1f5f9;
            }

            .delete-overlay {
                position: absolute;
                top: 30px;
                right: 30px;
                z-index: 25;
                background: #ef4444;
                color: white;
                width: 60px;
                height: 60px;
                border-radius: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                box-shadow: 0 15px 30px rgba(239, 68, 68, 0.4);
                transition: 0.4s;
            }

            .delete-overlay:hover { transform: scale(1.2) rotate(15deg); background: #dc2626; }

            .btn-submit {
                background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
                color: #fff !important;
                width: 100%;
                padding: 25px;
                border-radius: 22px;
                font-size: 24px;
                font-weight: 800;
                border: none;
                cursor: pointer;
                transition: 0.4s ease;
                margin-top: 50px;
                box-shadow: 0 20px 40px rgba(79, 70, 229, 0.3);
            }

            .input-group { margin-bottom: 40px; }

            @media (max-width: 768px) {
                .form-container { padding: 30px 20px; }
                h3 { font-size: 30px !important; }
                .custom-input { padding: 18px; font-size: 16px; }
            }
        </style>
    @endpush

    <div class="main-content-inner">
        <div class="form-container">
            <div class="text-center md:text-left">
                <h3>Edit Brand</h3>
                <p class="header-desc">Modify the details below to update your brand information.</p>
            </div>

            <form action="{{ route('admin.update-brand') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <input type="hidden" name="id" value="{{ $brand->id }}">

                <div class="input-group">
                    <label class="body-title">Brand Name <span class="text-red-500">*</span></label>
                    <input type="text" name="brand_name" class="custom-input" placeholder="Enter brand name" value="{{ $brand->name }}" required>
                    @error('brand_name') <p class="text-red-600 mt-3 font-bold text-lg">{{ $message }}</p> @enderror
                </div>

                <div class="input-group">
                    <label class="body-title">Brand Slug (Auto-Gen)</label>
                    <input type="text" name="brand_slug" class="custom-input" placeholder="brand-slug" value="{{ $brand->slug }}" readonly style="background: #f1f5f9; cursor: not-allowed;">
                    @error('brand_slug') <p class="text-red-600 mt-3 font-bold text-lg">{{ $message }}</p> @enderror
                </div>

                <div class="input-group">
                    <label class="body-title">Brand Logo Image</label>
                    <div class="upload-zone">
                        <div id="imgpreview" style="display: {{ $brand->image ? 'block' : 'none' }}">
                            <div class="delete-overlay" id="remove-img" title="Remove & Reset">
                                <i class="ri-delete-bin-fill text-3xl"></i>
                            </div>
                            <img src="{{ $brand->image ? asset('uploads/brands/' . $brand->image) : '' }}" alt="preview">
                        </div>

                        <label for="myFile" class="flex flex-col items-center cursor-pointer text-center" id="upload-label" style="display: {{ $brand->image ? 'none' : 'flex' }}">
                            <div class="w-28 h-28 bg-indigo-50 text-indigo-600 rounded-3xl flex items-center justify-center mb-6 transition-all hover:scale-110">
                                <i class="ri-image-edit-line text-5xl"></i>
                            </div>
                            <span class="text-1xl font-extrabold text-slate-800">Change Brand Logo</span>
                            <span class="text-slate-500 mt-3 text-lg">Click to browse or drop a new file</span>
                            <input type="file" id="myFile" name="brand_image" accept="image/*" class="hidden">
                        </label>
                    </div>
                    @error('brand_image') <p class="text-red-600 mt-3 font-bold text-lg">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="btn-submit">
                    <i class="ri-refresh-line mr-3"></i> Update Brand Details
                </button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const nameInput = document.querySelector('input[name="brand_name"]');
            const slugInput = document.querySelector('input[name="brand_slug"]');
            const fileInput = document.getElementById("myFile");
            const previewDiv = document.getElementById("imgpreview");
            const label = document.getElementById("upload-label");
            const imgTag = previewDiv.querySelector("img");
            const removeBtn = document.getElementById("remove-img");

            // ১. অটো স্লাগ জেনারেশন
            nameInput.addEventListener("input", function() {
                slugInput.value = nameInput.value.toLowerCase().trim()
                    .replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
            });

            // ২. নতুন ইমেজ প্রিভিউ
            fileInput.addEventListener("change", function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        imgTag.src = e.target.result;
                        previewDiv.style.display = "block";
                        label.style.display = "none";
                    }
                    reader.readAsDataURL(file);
                }
            });

            // ৩. ডিলিট ও রিসেট
            removeBtn.addEventListener("click", (e) => {
                e.preventDefault();
                fileInput.value = "";
                previewDiv.style.display = "none";
                label.style.display = "flex";
                imgTag.src = "";
            });
        });
    </script>
@endpush
