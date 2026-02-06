@extends('layouts.admin')

@section('content')
    <style>
        /* Aesthetic & High-Readability Styles */
        .profile-container {
            background: #ffffff;
            border-radius: 20px;
            padding: 50px;
            /* প্যাডিং আরও বাড়ানো হয়েছে */
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
            margin-top: 10px;
        }

        .profile-header-title {
            font-size: 1.8rem;
            /* হেডিং সাইজ বাড়ানো হয়েছে */
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
        }

        .main-profile-img {
            width: 180px;
            /* ইমেজ সাইজ বাড়ানো হয়েছে */
            height: 180px;
            object-fit: cover;
            border-radius: 30px;
            border: 6px solid #f1f5f9;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        /* টেক্সট সাইজ বড় করা হয়েছে এখানে */
        .info-label {
            font-size: 1rem;
            /* লেবেল বড় করা হয়েছে */
            text-transform: uppercase;
            color: #64748b;
            font-weight: 700;
            margin-bottom: 10px;
            display: block;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-size: 1.3rem;
            /* ভ্যালু বড় করা হয়েছে */
            color: #1e293b;
            font-weight: 600;
            line-height: 1.4;
        }

        .user-name-title {
            font-size: 1.7rem;
            /* ইউজারের নাম আরও বড় */
            font-weight: 800;
            color: #4f46e5;
            margin-top: 15px;
        }

        .info-item {
            background: #f8fafc;
            padding: 25px;
            /* ইনডোর প্যাডিং বাড়ানো হয়েছে */
            border-radius: 15px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .info-item:hover {
            background: #ffffff;
            border-color: #4f46e5;
            transform: translateY(-3px);
        }

        .section-title-bar {
            border-left: 6px solid #4f46e5;
            padding-left: 20px;
            margin-bottom: 35px;
        }

        /* ফর্ম ইনপুট বড় করা হয়েছে */
        .form-style-custom .body-title {
            font-size: 1.1rem !important;
            font-weight: 700 !important;
            margin-bottom: 12px !important;
            color: #334155;
        }

        .form-style-custom input {
            height: 60px !important;
            /* ইনপুট হাইট বাড়ানো হয়েছে */
            border-radius: 12px !important;
            border: 2px solid #e2e8f0 !important;
            /* বর্ডার আরও স্পষ্ট */
            padding: 15px 25px !important;
            font-size: 1.1rem !important;
            /* ইনপুট টেক্সট বড় */
            font-weight: 500;
        }

        .btn-aesthetic {
            padding: 15px 35px !important;
            font-size: 1.1rem !important;
            font-weight: 700 !important;
            border-radius: 12px !important;
        }

        .badge-admin {
            font-size: 0.9rem;
            padding: 8px 20px;
            background: #eef2ff;
            color: #4f46e5;
            font-weight: 700;
            border-radius: 50px;
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3 class="fw-8" style="font-size: 2rem;">Settings</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li><a href="{{ route('dashboard') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Settings</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box" style="padding: 0; background: transparent; border: none;">
                <div class="col-lg-12">
                    <div class="page-content">

                        {{-- ১. প্রোফাইল ভিউ মোড --}}
                        <div id="profile-view-section" class="profile-container">
                            <div class="flex items-center justify-between mb-40">
                                <div class="section-title-bar">
                                    <h5 class="profile-header-title mb-1">Personal Account Details</h5>
                                    <p class="text-muted" style="font-size: 1.1rem;">Your information is kept secure and
                                        private.</p>
                                </div>
                                <button type="button" class="tf-button btn-aesthetic btn-save" onclick="showEditMode()">
                                    <i class="icon-edit-3"></i> Edit My Profile
                                </button>
                            </div>

                            <div class="row items-center">
                                <div class="col-md-4 text-center">
                                    <div class="profile-image-section mb-3">
                                        <img src="{{ auth()->user()->image ? asset('uploads/profile/' . auth()->user()->image) : asset('images/no-image.png') }}"
                                            class="main-profile-img" alt="Profile">
                                    </div>
                                    <h4 class="user-name-title">{{ auth()->user()->name }}</h4>
                                    <span class="badge-admin">System Administrator</span>
                                </div>

                                <div class="col-md-8">
                                    <div class="info-grid">
                                        <div class="info-item">
                                            <span class="info-label">Display Name</span>
                                            <span class="info-value">{{ auth()->user()->name }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Email Address</span>
                                            <span class="info-value">{{ auth()->user()->email }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Contact Number</span>
                                            <span
                                                class="info-value">{{ auth()->user()->mobile ?? 'No Number Provided' }}</span>
                                        </div>
                                        <div class="info-item" style="border-left: 5px solid #10b981;">
                                            <span class="info-label">Verification Status</span>
                                            <span class="info-value text-success">Verified Account</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ২. প্রোফাইল এডিট মোড --}}
                        <div id="profile-edit-section" style="display: none;" class="profile-container">
                            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data"
                                class="form-style-custom">
                                @csrf
                                @method('PUT')

                                <div class="section-title-bar">
                                    <h5 class="profile-header-title">Update Your Account Information</h5>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-4 mb-4">
                                        <div class="text-center p-4"
                                            style="background: #f8fafc; border-radius: 15px; border: 2px dashed #cbd5e1;">
                                            <div class="body-title">Profile Image</div>
                                            <img id="img-preview"
                                                src="{{ auth()->user()->image ? asset('uploads/profile/' . auth()->user()->image) : asset('images/no-image.png') }}"
                                                class="rounded-circle mb-3"
                                                style="width: 140px; height: 140px; object-fit: cover; border: 5px solid #fff; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                                            <input type="file" name="image" id="image-input" class="form-control"
                                                accept="image/*">
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <fieldset>
                                                    <div class="body-title">Your Full Name <span class="tf-color-1">*</span>
                                                    </div>
                                                    <input type="text" name="name" value="{{ auth()->user()->name }}"
                                                        required>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-6">
                                                <fieldset>
                                                    <div class="body-title">Mobile Number <span class="tf-color-1">*</span>
                                                    </div>
                                                    <input type="text" name="mobile"
                                                        value="{{ auth()->user()->mobile }}" required>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-12">
                                                <fieldset>
                                                    <div class="body-title">Email Address <span class="tf-color-1">*</span>
                                                    </div>
                                                    <input type="email" name="email"
                                                        value="{{ auth()->user()->email }}" required>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 my-5">
                                        <div class="d-flex align-items-center gap-3">
                                            <h5 class="fw-8 mb-0" style="color: #4f46e5; font-size: 1.4rem;"><i
                                                    class="icon-shield"></i> Security Management</h5>
                                            <div class="flex-grow-1"
                                                style="height: 2px; background: #e2e8f0; border-radius: 10px;"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <fieldset>
                                            <div class="body-title">Current Password</div>
                                            <input type="password" name="old_password" placeholder="••••••••">
                                        </fieldset>
                                    </div>
                                    <div class="col-md-4">
                                        <fieldset>
                                            <div class="body-title">New Password</div>
                                            <input type="password" name="new_password" placeholder="••••••••">
                                        </fieldset>
                                    </div>
                                    <div class="col-md-4">
                                        <fieldset>
                                            <div class="body-title">Confirm Password</div>
                                            <input type="password" name="new_password_confirmation"
                                                placeholder="••••••••">
                                        </fieldset>
                                    </div>

                                    <div class="col-md-12 mt-5">
                                        <div class="flex gap20">
                                            <button type="submit" class="tf-button btn-aesthetic btn-save">Save Profile
                                                Updates</button>
                                            <button type="button" class="tf-button btn-aesthetic btn-cancel"
                                                onclick="hideEditMode()">Dismiss Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showEditMode() {
            document.getElementById('profile-view-section').style.display = 'none';
            document.getElementById('profile-edit-section').style.display = 'block';
        }

        function hideEditMode() {
            document.getElementById('profile-view-section').style.display = 'block';
            document.getElementById('profile-edit-section').style.display = 'none';
        }

        document.getElementById('image-input').onchange = function(evt) {
            const [file] = this.files;
            if (file) {
                document.getElementById('img-preview').src = URL.createObjectURL(file);
            }
        }
    </script>
@endsection
