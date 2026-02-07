@extends('layouts.admin')

@section('content')
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap');

            .main-content-inner {
                font-family: 'Plus Jakarta Sans', sans-serif;
                background: #f0f2f5;
                padding: 40px 25px;
            }

            .page-title {
                font-size: 32px !important;
                font-weight: 800;
                background: linear-gradient(to right, #1e293b, #4f46e5);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                letter-spacing: -1px;
            }

            .wg-box {
                background: #ffffff;
                border-radius: 30px;
                padding: 40px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
                border: 1px solid #f1f5f9;
            }

            /* ফর্ম ফিল্ড ডিজাইন */
            fieldset { margin-bottom: 25px; border: none; }
            .body-title {
                font-weight: 700;
                color: #334155;
                margin-bottom: 10px;
                font-size: 15px;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            input[type="text"], select {
                width: 100%;
                padding: 14px 20px !important;
                border-radius: 14px !important;
                border: 2px solid #f1f5f9 !important;
                background: #f8fafc !important;
                transition: 0.3s;
                font-weight: 600;
            }

            input:focus, select:focus {
                border-color: #4f46e5 !important;
                background: #fff !important;
                box-shadow: 0 8px 20px rgba(79, 70, 229, 0.08) !important;
                outline: none;
            }

            /* ইমেজ আপলোড জোন */
            .upload-image-wrapper {
                position: relative;
                width: 100%;
                min-height: 200px;
                border: 2px dashed #cbd5e1;
                border-radius: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #f8fafc;
                transition: 0.3s;
                overflow: hidden;
            }
            .upload-image-wrapper:hover { border-color: #4f46e5; background: #f1f0ff; }

            .uploadfile {
                cursor: pointer;
                text-align: center;
                width: 100%;
                height: 100%;
                padding: 40px;
            }

            /* প্রিভিউ এরিয়া */
            #preview-container {
                display: none;
                position: relative;
                width: 100%;
                max-width: 400px;
                border-radius: 15px;
                overflow: hidden;
                box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            }
            #preview { width: 100%; height: auto; display: block; }

            /* অ্যানিমেটেড ডিলিট বাটন */
            .delete-img-btn {
                position: absolute;
                top: 15px;
                right: 15px;
                width: 40px;
                height: 40px;
                background: rgba(239, 68, 68, 0.9);
                color: white;
                border: none;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                backdrop-filter: blur(4px);
            }
            .delete-img-btn:hover {
                transform: scale(1.2) rotate(90deg);
                background: #ef4444;
            }
            .delete-img-btn i { font-size: 20px; }

            /* সেভ বাটন */
            .tf-button {
                background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
                color: white !important;
                padding: 16px 45px;
                border-radius: 16px;
                font-weight: 800;
                border: none;
                cursor: pointer;
                transition: 0.4s;
                box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
            }
            .tf-button:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(79, 70, 229, 0.4); }

            @media (max-width: 768px) { .wg-box { padding: 25px; } }
        </style>
    @endpush

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h3 class="page-title">Create New Slide</h3>
                    <div class="flex items-center gap-2 text-slate-500 font-medium mt-1">
                        <span>Sliders</span> <i class="ri-arrow-right-s-line"></i> <span>New Entry</span>
                    </div>
                </div>
                <a href="{{ route('admin.slide.index') }}" class="text-slate-500 font-bold flex items-center gap-2">
                    <i class="ri-arrow-left-circle-line text-2xl"></i> Back to List
                </a>
            </div>

            <div class="wg-box">
                <form class="form-new-product" action="{{ route('admin.slide.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <fieldset>
                                <div class="body-title"><i class="ri-price-tag-3-line text-indigo-500"></i> Tagline <span class="text-danger">*</span></div>
                                <input type="text" placeholder="Enter slider tagline" name="tagline" value="{{ old('tagline') }}" required>
                                @error('tagline') <p class="text-danger mt-2 font-bold">{{ $message }}</p> @enderror
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <fieldset>
                                <div class="body-title"><i class="ri-font-size text-indigo-500"></i> Title <span class="text-danger">*</span></div>
                                <input type="text" placeholder="Enter main title" name="title" value="{{ old('title') }}" required>
                                @error('title') <p class="text-danger mt-2 font-bold">{{ $message }}</p> @enderror
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <fieldset>
                                <div class="body-title"><i class="ri-subtitles-line text-indigo-500"></i> Subtitle <span class="text-danger">*</span></div>
                                <input type="text" placeholder="Enter subtitle" name="subtitle" value="{{ old('subtitle') }}" required>
                                @error('subtitle') <p class="text-danger mt-2 font-bold">{{ $message }}</p> @enderror
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <fieldset>
                                <div class="body-title"><i class="ri-links-line text-indigo-500"></i> Target Link <span class="text-danger">*</span></div>
                                <input type="text" placeholder="https://example.com/shop" name="link" value="{{ old('link') }}" required>
                                @error('link') <p class="text-danger mt-2 font-bold">{{ $message }}</p> @enderror
                            </fieldset>
                        </div>
                    </div>

                    <fieldset>
                        <div class="body-title"><i class="ri-image-add-line text-indigo-500"></i> Slider Image <span class="text-danger">*</span></div>

                        <div class="upload-image-wrapper" id="upload-zone">
                            <label class="uploadfile" for="myFile" id="upload-label">
                                <i class="ri-upload-cloud-2-line text-5xl text-indigo-500 mb-2"></i>
                                <div class="body-text font-bold">Drop your image here or <span class="text-indigo-600">browse</span></div>
                                <input type="file" id="myFile" name="image" onchange="previewImage(event)" hidden>
                            </label>

                            <div id="preview-container">
                                <img id="preview" src="">
                                <button type="button" class="delete-img-btn" onclick="removeImage()" title="Remove Image">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </div>
                        @error('image') <p class="text-danger mt-2 font-bold">{{ $message }}</p> @enderror
                    </fieldset>

                    <fieldset>
                        <div class="body-title"><i class="ri-toggle-line text-indigo-500"></i> Visibility Status</div>
                        <select name="status">
                            <option value="1" @if (old('status') == '1') selected @endif>Active (Visible on Site)</option>
                            <option value="0" @if (old('status') == '0') selected @endif>Inactive (Hidden)</option>
                        </select>
                        @error('status') <p class="text-danger mt-2 font-bold">{{ $message }}</p> @enderror
                    </fieldset>

                    <div class="mt-10 flex justify-end">
                        <button class="tf-button" type="submit"><i class="ri-save-3-line"></i> Publish Slider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const output = document.getElementById('preview');
                const container = document.getElementById('preview-container');
                const label = document.getElementById('upload-label');
                const zone = document.getElementById('upload-zone');

                output.src = URL.createObjectURL(file);
                container.style.display = "block";
                label.style.display = "none";
                zone.style.borderStyle = "solid";

                output.onload = function() {
                    URL.revokeObjectURL(output.src);
                }
            }
        }

        function removeImage() {
            const input = document.getElementById('myFile');
            const output = document.getElementById('preview');
            const container = document.getElementById('preview-container');
            const label = document.getElementById('upload-label');
            const zone = document.getElementById('upload-zone');

            input.value = ""; // ক্লিয়ার ইনপুট
            output.src = "";
            container.style.display = "none";
            label.style.display = "block";
            zone.style.borderStyle = "dashed";
        }
    </script>
@endpush
