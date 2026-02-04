@extends('layouts.app')
@section('content')
    <style>
        .my-account {
            padding-top: 50px;
            padding-bottom: 80px;
            background-color: #f9f9f9;
        }

        .page-title {
            font-size: 28px;
            font-weight: 800;
            color: #111;
            margin-bottom: 30px;
        }

        .account-nav {
            list-style: none;
            padding: 0;
            border-radius: 15px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .menu-link_us-s {
            display: block;
            padding: 15px 25px;
            font-size: 14px;
            font-weight: 600;
            color: #666;
            text-decoration: none;
            border-left: 4px solid transparent;
        }

        .menu-link_us-s.active {
            background: #f8f9fa;
            color: #000;
            border-left-color: #000;
        }

        .account-card {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
        }

        /* Profile Image */
        .profile-img-container {
            width: 120px;
            height: 120px;
            margin: 0 auto 20px;
            position: relative;
        }

        .profile-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #eee;
        }

        .upload-badge {
            position: absolute;
            bottom: 0;
            right: 0;
            background: #000;
            color: #fff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 2px solid #fff;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #f5f5f5;
        }

        .info-label {
            font-weight: 700;
            color: #888;
            font-size: 13px;
            text-transform: uppercase;
        }

        .info-value {
            font-weight: 600;
            color: #222;
        }

        .form-control {
            border-radius: 10px;
            background: #fbfbfb;
            padding: 12px;
        }

        .btn-edit-toggle {
            background: #111;
            color: #fff;
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 600;
        }

        .hidden {
            display: none;
        }

        .my-account {
            padding-top: 50px;
            padding-bottom: 80px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 800;
            color: #111;
            margin-bottom: 30px;
            letter-spacing: -0.5px;
        }

        /* Left Sidebar Navigation */
        .account-nav {
            list-style: none;
            padding: 0;
            border: 1px solid #efefef;
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
        }

        .account-nav li {
            /* border-bottom: 1px solid #efefef; */
        }

        .account-nav li:last-child {
            border-bottom: none;
        }

        .menu-link_us-s {
            display: block;
            padding: 15px 20px;
            font-size: 14px;
            font-weight: 600;
            color: #666;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            /* ডিফল্ট ট্রান্সপারেন্ট বর্ডার */
        }

        .menu-link_us-s:hover {
            background: #fcfcfc;
            color: #000;
            text-decoration: none;

        }

        /* একটিভ ক্লাসের স্টাইল */
        .menu-link_us-s.active {
            background: #fcfcfc;
            color: #000;
            border-left: 4px solid #000;
        }


        .menu-link_us-s::after {
            display: none !important;
            content: none !important;
            width: 0 !important;
        }

        /* হোভার করলেও যেন ফিরে না আসে */
        .menu-link_us-s:hover::after,
        .menu-link_us-s.active::after {
            display: none !important;
            width: 0 !important;
        }
    </style>

    <main class="pt-90">
        <div class="container my-account">
            <h2 class="page-title">Account Details</h2>
            <div class="row gx-lg-5">
                <div class="col-lg-3">
                    <ul class="account-nav shadow-sm mb-5">
                        <li><a href="{{ route('user.index') }}" class="menu-link menu-link_us-s">Dashboard</a></li>
                        <li><a href="{{ route('user.address') }}" class="menu-link menu-link_us-s">Addresses</a></li>
                        <li><a href="{{ route('user.orders') }}"
                                class="menu-link menu-link_us-s {{ request()->routeIs('user.orders') ? 'active' : '' }}">Orders</a>
                        </li>
                        <li><a href="{{ route('user.account.details') }}" class="menu-link menu-link_us-s active">Account
                                Details</a></li>
                        <li><a href="{{ route('user.wishlist') }}"
                                class="menu-link menu-link_us-s {{ request()->routeIs('user.wishlist') ? 'active' : '' }}">Wishlist</a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="post" id="logout-form">
                                @csrf
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit()"
                                    class="menu-link menu-link_us-s text-danger">Logout</a>
                            </form>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-9">
                    <div class="account-card">
                        {{-- @if (session('success'))
                            <div class="alert alert-success border-0 mb-4">{{ session('success') }}</div>
                        @endif --}}

                        <div id="viewMode">
                            <div class="text-center mb-4">
                                <div class="profile-img-container">
                                    <img src="{{ $user->image ? asset('uploads/users/' . $user->image) : asset('images/no-image.png') }}"
                                        class="profile-img">
                                </div>
                                <h4 class="fw-bold">{{ $user->name }}</h4>
                                <p class="text-muted">{{ $user->email }}</p>
                                <button type="button" id="enableEdit" class="btn-edit-toggle mt-2">Edit Profile</button>
                            </div>

                            <div class="info-row"><span class="info-label">Full Name</span><span
                                    class="info-value">{{ $user->name }}</span></div>
                            <div class="info-row"><span class="info-label">Mobile</span><span
                                    class="info-value">{{ $user->mobile ?? 'Not Set' }}</span></div>
                            <div class="info-row"><span class="info-label">Email</span><span
                                    class="info-value">{{ $user->email }}</span></div>
                        </div>

                        <div id="editMode" class="hidden">
                            <form action="{{ route('user.account.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="text-center mb-4">
                                    <div class="profile-img-container">
                                        <img src="{{ $user->image ? asset('uploads/users/' . $user->image) : asset('images/no-image.png') }}"
                                            id="imagePreview" class="profile-img">
                                        <label for="imageUpload" class="upload-badge"><i class="fa fa-camera"></i></label>
                                        <input type="file" id="imageUpload" name="image" accept="image/*"
                                            class="hidden">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small fw-bold">Full Name</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $user->name }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small fw-bold">Mobile Number</label>
                                        <input type="text" class="form-control" name="mobile"
                                            value="{{ $user->mobile }}">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label small fw-bold">Email Address</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ $user->email }}">
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <h6 class="fw-bold">Change Password (Optional)</h6>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <input type="password" class="form-control" name="old_password"
                                            placeholder="Current Password">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="password" class="form-control" name="new_password"
                                            placeholder="New Password">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="password" class="form-control" name="new_password_confirmation"
                                            placeholder="Confirm New Password">
                                    </div>
                                </div>

                                <div class="d-flex gap-2 mt-4">
                                    <button type="submit" class="btn btn-dark w-100 py-3 rounded-3 fw-bold">Update
                                        Details</button>
                                    <button type="button" id="cancelEdit"
                                        class="btn btn-light w-100 py-3 rounded-3 fw-bold border">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const viewMode = document.getElementById('viewMode');
            const editMode = document.getElementById('editMode');
            const enableEditBtn = document.getElementById('enableEdit');
            const cancelEditBtn = document.getElementById('cancelEdit');
            const imageUpload = document.getElementById('imageUpload');
            const imagePreview = document.getElementById('imagePreview');

            // Toggle Modes
            enableEditBtn.addEventListener('click', () => {
                viewMode.classList.add('hidden');
                editMode.classList.remove('hidden');
            });

            cancelEditBtn.addEventListener('click', () => {
                editMode.classList.add('hidden');
                viewMode.classList.remove('hidden');
            });

            // Image Preview
            imageUpload.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => imagePreview.src = e.target.result;
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endpush
