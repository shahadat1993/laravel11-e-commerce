@extends('layouts.admin')



@section('content')
    <div class="main-content-inner">

        <div class="main-content-wrap">

            <div class="flex items-center flex-wrap justify-between gap20 mb-27">

                <h3>Settings</h3>

                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">

                    <li>

                        <a href="{{ route('dashboard') }}">

                            <div class="text-tiny">Dashboard</div>

                        </a>

                    </li>

                    <li><i class="icon-chevron-right"></i></li>

                    <li>
                        <div class="text-tiny">Settings</div>
                    </li>

                </ul>

            </div>



            <div class="wg-box">

                <div class="col-lg-12">

                    <div class="page-content my-account__edit">



                        {{-- ১. প্রোফাইল ভিউ মোড (Default) --}}

                        <div id="profile-view-section">

                            <div class="flex items-center justify-between mb-30">

                                <h5 class="text-uppercase mb-0">My Profile</h5>

                                <button type="button" class="tf-button style-1 w208" onclick="showEditMode()">

                                    <i class="icon-edit-3"></i> Change Profile

                                </button>

                            </div>



                            <div class="row items-center">

                                <div class="col-md-3">

                                    <div class="profile-image-wrapper mb-3 text-center">

                                        <img src="{{ auth()->user()->image ? asset('uploads/profile/' . auth()->user()->image) : asset('images/no-image.png') }}"
                                            class="img-fluid rounded-circle border"
                                            style="width: 150px; height: 150px; object-fit: cover;" alt="Profile">

                                    </div>

                                </div>

                                <div class="col-md-9">

                                    <div class="user-details-info">

                                        <p class="mb-2"><strong>Full Name:</strong> {{ auth()->user()->name }}</p>

                                        <p class="mb-2"><strong>Email Address:</strong> {{ auth()->user()->email }}</p>

                                        <p class="mb-2"><strong>Mobile Number:</strong>
                                            {{ auth()->user()->mobile ?? 'N/A' }}</p>

                                    </div>

                                </div>

                            </div>

                        </div>



                        {{-- ২. প্রোফাইল এডিট মোড (Hidden by default) --}}

                        <div id="profile-edit-section" style="display: none;">

                            <form name="account_edit_form" action="{{ route('admin.profile.update') }}" method="POST"
                                enctype="multipart/form-data" class="form-new-product form-style-1">
                                @csrf
                                @method('PUT')

                                <div class="row">

                                    <div class="col-md-12">

                                        <h5 class="text-uppercase mb-20">Edit Your Information</h5>

                                    </div>



                                    {{-- ইমেজ সেকশন এবং প্রিভিউ লজিক --}}

                                    <div class="col-md-12 mb-4">

                                        <div class="body-title mb-10">Profile Picture</div>

                                        <div class="upload-image-preview mb-3">

                                            <img id="img-preview"
                                                src="{{ auth()->user()->image ? asset('uploads/profile/' . auth()->user()->image) : asset('images/no-image.png') }}"
                                                class="rounded border"
                                                style="width: 120px; height: 120px; object-fit: cover;">

                                        </div>

                                        <input type="file" name="image" id="image-input" class="form-control"
                                            accept="image/*">
                                        @error('image')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror

                                    </div>



                                    <div class="col-md-12">

                                        <fieldset class="name">

                                            <div class="body-title">Name <span class="tf-color-1">*</span></div>

                                            <input class="flex-grow" type="text" name="name"
                                                value="{{ auth()->user()->name }}" required>

                                        </fieldset>
                                        @error('name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror

                                    </div>



                                    <div class="col-md-12">

                                        <fieldset class="name">

                                            <div class="body-title">Mobile Number <span class="tf-color-1">*</span></div>

                                            <input class="flex-grow" type="text" name="mobile"
                                                value="{{ auth()->user()->mobile }}" required>

                                        </fieldset>
                                        @error('mobile')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror

                                    </div>



                                    <div class="col-md-12">

                                        <fieldset class="name">

                                            <div class="body-title">Email Address <span class="tf-color-1">*</span></div>

                                            <input class="flex-grow" type="email" name="email"
                                                value="{{ auth()->user()->email }}" required>

                                        </fieldset>
                                        @error('email')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror

                                    </div>



                                    <div class="col-md-12 mt-4">

                                        <h5 class="text-uppercase mb-20">Security & Password</h5>

                                    </div>



                                    <div class="col-md-4">

                                        <fieldset class="name">

                                            <div class="body-title">Old Password</div>

                                            <input type="password" name="old_password" placeholder="********">

                                        </fieldset>
                                        @error('old_password')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror

                                    </div>

                                    <div class="col-md-4">

                                        <fieldset class="name">

                                            <div class="body-title">New Password</div>

                                            <input type="password" name="new_password" placeholder="********">

                                        </fieldset>
                                        @error('new_password')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror

                                    </div>

                                    <div class="col-md-4">

                                        <fieldset class="name">

                                            <div class="body-title">Confirm Password</div>

                                            <input type="password" name="new_password_confirmation"
                                                placeholder="********">

                                        </fieldset>
                                        @error('new_password_confirmation')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror

                                    </div>



                                    <div class="col-md-12">

                                        <div class="my-3 flex gap10">

                                            <button type="submit" class="tf-button w208">Save Changes</button>

                                            <button type="button" class="tf-button style-1 w208"
                                                onclick="hideEditMode()">Cancel</button>

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



    {{-- জাভাস্ক্রিপ্ট লজিক --}}

    <script>
        // এডিট মোড দেখানো এবং লুকানোর ফাংশন

        function showEditMode() {

            document.getElementById('profile-view-section').style.display = 'none';

            document.getElementById('profile-edit-section').style.display = 'block';

        }



        function hideEditMode() {

            document.getElementById('profile-view-section').style.display = 'block';

            document.getElementById('profile-edit-section').style.display = 'none';

        }



        // ইমেজ সিলেক্ট করলে সাথে সাথে প্রিভিউ দেখার লজিক

        document.getElementById('image-input').onchange = function(evt) {

            const [file] = this.files;

            if (file) {

                document.getElementById('img-preview').src = URL.createObjectURL(file);

            }

        }
    </script>
@endsection
