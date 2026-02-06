@extends('layouts.admin')

@section('content')
    <style>
        /* Professional Form Container */
        .form-container {
            background: #ffffff;
            border-radius: 20px;
            padding: 45px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
            margin-top: 10px;
        }

        .form-header-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
        }

        .section-title-bar {
            border-left: 6px solid #4f46e5;
            padding-left: 20px;
            margin-bottom: 35px;
        }

        /* Input Styling */
        .form-group-label {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 12px;
            color: #334155;
            display: block;
        }

        .custom-input,
        .custom-select {
            height: 60px !important;
            border-radius: 12px !important;
            border: 2px solid #e2e8f0 !important;
            padding: 15px 20px !important;
            font-size: 1.1rem !important;
            width: 100%;
            transition: all 0.3s ease;
            background-color: #f8fafc;
        }

        .custom-input:focus,
        .custom-select:focus {
            border-color: #4f46e5 !important;
            background-color: #ffffff;
            box-shadow: 0 0 0 5px rgba(79, 70, 229, 0.1) !important;
            outline: none;
        }

        /* Image Upload & Preview Section */
        .image-preview-container {
            border: 2px dashed #cbd5e1;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            background: #f8fafc;
            position: relative;
            transition: all 0.3s ease;
            min-height: 250px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .image-preview-container:hover {
            border-color: #4f46e5;
            background: #eff6ff;
        }

        #image-display {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            display: none;
            border: 4px solid #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        /* Delete Button Style */
        .remove-img-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #ef4444;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 2px solid white;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
            z-index: 10;
            transition: all 0.2s ease;
            font-size: 20px
        }

        .remove-img-btn:hover {
            background: #dc2626;
            transform: scale(1.1);
        }

        .upload-placeholder i {
            font-size: 3.5rem;
            color: #94a3b8;
        }

        /* Right side illustration */
        .user-illustration {
            background: linear-gradient(135deg, #e0e7ff 0%, #ffffff 100%);
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            border: 1px solid #e2e8f0;
        }

        .btn-submit {
            background: #4f46e5 !important;
            color: white !important;
            padding: 16px 40px !important;
            font-size: 1.1rem !important;
            font-weight: 700 !important;
            border-radius: 12px !important;
            border: none;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .icon-box {
            font-size: 1.5rem;
            color: #4f46e5;
            margin-right: 10px;
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3 class="fw-8" style="font-size: 2rem;">User Management</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li><a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Create User</div>
                    </li>
                </ul>
            </div>

            <div class="form-container">
                <div class="section-title-bar">
                    <h5 class="form-header-title mb-1">Create New System User</h5>
                    <p class="text-muted" style="font-size: 1.1rem;">Assign roles, set profile photo, and security details.
                    </p>
                </div>

                <form action="{{ route('admin.createUser.store') }}" method="POST" enctype="multipart/form-data"
                    class="mt-4">
                    @csrf

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-group-label"><i class="ri-user-line icon-box"></i> Full Name</label>
                                    <input type="text" name="name"
                                        class="custom-input @error('name') is-invalid @enderror" placeholder="Ex: Jhon Doe"
                                        value="{{ old('name') }}" required>

                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-group-label"><i class="ri-smartphone-line icon-box"></i> Mobile
                                        Number</label>
                                    <input type="text" name="mobile"
                                        class="custom-input @error('mobile') is-invalid @enderror" placeholder="01XXXXXXXXX"
                                        value="{{ old('mobile') }}" required>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label class="form-group-label"><i class="ri-mail-line icon-box"></i> Email
                                        Address</label>
                                    <input type="email" name="email"
                                        class="custom-input @error('email') is-invalid @enderror"
                                        placeholder="john@example.com" value="{{ old('email') }}" required>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label class="form-group-label"><i class="ri-image-circle-line icon-box"></i> Profile
                                        Photo</label>
                                    <div class="image-preview-container" id="upload-box"
                                        onclick="document.getElementById('imageInput').click();">
                                        <div class="remove-img-btn" id="remove-btn" title="Remove image"
                                            onclick="removeImage(event)">
                                            <i class="ri-delete-bin-line"></i>
                                        </div>
                                        <div class="upload-placeholder" id="placeholder-content">
                                            <i class="ri-upload-cloud-2-line"></i>
                                            <p class="mt-2 mb-0 fw-bold">Click to upload or drag and drop</p>
                                            <p class="text-muted small">SVG, PNG, JPG or GIF (max. 2MB)</p>
                                        </div>
                                        <img id="image-display" src="#" alt="User Preview">
                                        <input type="file" name="image" id="imageInput" hidden accept="image/*"
                                            onchange="previewImage(this)">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-group-label"><i class="ri-lock-2-line icon-box"></i> Password</label>
                                    <input type="password" name="password" class="custom-input" placeholder="••••••••"
                                        required>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-group-label"><i class="ri-lock-password-line icon-box"></i> Confirm
                                        Password</label>
                                    <input type="password" name="password_confirmation" class="custom-input"
                                        placeholder="••••••••" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="user-illustration">
                                <div class="mb-4">
                                    <i class="ri-shield-user-fill" style="font-size: 4rem; color: #4f46e5;"></i>
                                </div>
                                <label class="form-group-label text-center">Assign Account Role</label>
                                <select name="roles[]" class="custom-select" required>
                                    <option value="" selected disabled>Select a Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                    @endforeach
                                </select>
                                <p class="text-muted small mt-3">The role determines what actions this user can perform in
                                    the system.</p>
                            </div>
                        </div>

                        <div class="col-md-12 mt-5">
                            <hr style="border-top: 2px dashed #e2e8f0;">
                            <div class="flex gap20 mt-4">
                                <button type="submit" class="btn-submit">
                                    <i class="ri-user-add-line"></i> Create User Account
                                </button>
                                <a href="{{ route('admin.index') }}" class="btn-submit"
                                    style="background: #f1f5f9 !important; color: #475569 !important;">
                                    Cancel & Back
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const file = input.files[0];
            const placeholder = document.getElementById('placeholder-content');
            const imageDisplay = document.getElementById('image-display');
            const removeBtn = document.getElementById('remove-btn');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imageDisplay.src = e.target.result;
                    imageDisplay.style.display = 'block';
                    placeholder.style.display = 'none';
                    removeBtn.style.display = 'flex';
                }
                reader.readAsDataURL(file);
            }
        }

        function removeImage(event) {
            event.stopPropagation();
            const input = document.getElementById('imageInput');
            const placeholder = document.getElementById('placeholder-content');
            const imageDisplay = document.getElementById('image-display');
            const removeBtn = document.getElementById('remove-btn');

            input.value = "";
            imageDisplay.src = "#";
            imageDisplay.style.display = 'none';
            placeholder.style.display = 'block';
            removeBtn.style.display = 'none';
        }
    </script>
@endsection
