@extends('layouts.app')
@section('content')
    <style>
        /* Global Dashboard & Typography */
        .my-account { padding-top: 50px; padding-bottom: 80px; background-color: #fff; }
        .page-title { font-size: 30px; font-weight: 800; color: #111; margin-bottom: 40px; letter-spacing: -1px; }

        /* Left Sidebar Navigation */
        .account-nav { list-style: none; padding: 0; border: 1px solid #f0f0f0; border-radius: 16px; overflow: hidden; background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.03); }
        .account-nav li { border-bottom: 1px solid #f8f8f8; }
        .account-nav li:last-child { border-bottom: none; }

        .menu-link_us-s {
            display: block; padding: 16px 24px; font-size: 14px; font-weight: 600; color: #666;
            text-decoration: none; transition: all 0.3s ease; border-left: 4px solid transparent;
        }
        .menu-link_us-s:hover { background: #fbfbfb; color: #000; text-decoration: none; }
        .menu-link_us-s.active { background: #fbfbfb; color: #000; border-left: 4px solid #000; }
        .text-danger.menu-link_us-s:hover { color: #dc3545 !important; }

        /* Form Card Design */
        .address-form-card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); background: #fff; overflow: hidden; }
        .card-header-custom { background: #111; padding: 25px 35px; border: none; }
        .card-header-custom h5 { color: #fff; font-weight: 700; font-size: 18px; margin: 0; }
        .card-body-custom { padding: 40px; }

        /* Input Styling */
        .form-label { font-size: 12px; font-weight: 700; color: #999; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; }
        .form-control {
            height: 52px; border-radius: 12px; border: 1px solid #eee; background: #f9f9f9;
            padding: 10px 20px; font-size: 15px; transition: all 0.3s;
        }
        .form-control:focus { background: #fff; border-color: #111; box-shadow: 0 0 0 4px rgba(0,0,0,0.03); outline: none; }

        /* Buttons */
        .btn-save-address {
            background: #111; color: #fff; border: none; padding: 16px 40px; border-radius: 12px;
            font-weight: 700; font-size: 15px; transition: all 0.3s; width: 100%;
        }
        .btn-save-address:hover { background: #333; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }

        .btn-back {
            background: #f1f1f1; color: #555; border: none; padding: 8px 20px; border-radius: 8px;
            font-weight: 600; font-size: 13px; transition: 0.3s; text-decoration: none;
        }
        .btn-back:hover { background: #e5e5e5; color: #000; }

        .notice-text { font-size: 14px; color: #777; line-height: 1.6; }

        /* Cleaning theme interference */
        .menu-link_us-s::after { display: none !important; content: none !important; }
    </style>

    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">My Account</h2>

            <div class="row gx-lg-5">
                {{-- Left Sidebar --}}
                <div class="col-lg-3 mb-5">
                    <ul class="account-nav shadow-sm" id="account-menu">
                        <li><a href="{{ route('user.index') }}" class="menu-link menu-link_us-s {{ request()->routeIs('user.index') ? 'active' : '' }}">Dashboard</a></li>
                        <li><a href="{{ route('user.orders') }}" class="menu-link menu-link_us-s {{ request()->routeIs('user.orders') ? 'active' : '' }}">Orders</a></li>
                        <li><a href="{{ route('user.address') }}" class="menu-link menu-link_us-s {{ request()->routeIs('user.address*') ? 'active' : '' }}">Addresses</a></li>
                        <li><a href="{{ route('user.account.details') }}" class="menu-link menu-link_us-s {{ request()->routeIs('user.account.details') ? 'active' : '' }}">Account Details</a></li>
                        <li><a href="{{ route('user.wishlist') }}" class="menu-link menu-link_us-s {{ request()->routeIs('user.wishlist') ? 'active' : '' }}">Wishlist</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="post" id="logout-form">
                                @csrf
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit()" class="menu-link menu-link_us-s text-danger">Logout</a>
                            </form>
                        </li>
                    </ul>
                </div>

                {{-- Main Content --}}
                <div class="col-lg-9">
                    <div class="page-content">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="fw-800 mb-1">Add Shipping Address</h4>
                                <p class="notice-text mb-0">Please fill in the details below to add a new address.</p>
                            </div>
                            <a href="{{ route('user.address') }}" class="btn-back">
                                <i class="fa fa-arrow-left me-2"></i>Back
                            </a>
                        </div>

                        <form action="{{ route('user.address.store') }}" method="POST">
                            @csrf
                            <div class="address-form-card">
                                <div class="card-header-custom">
                                    <h5>Address Information</h5>
                                </div>

                                <div class="card-body-custom">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label">Recipient Full Name</label>
                                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="e.g. John Doe">
                                            @error('name') <small class="text-danger mt-1 d-block fw-bold">{{ $message }}</small> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Phone Number</label>
                                            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="e.g. +88017XXXXXXXX">
                                            @error('phone') <small class="text-danger mt-1 d-block fw-bold">{{ $message }}</small> @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">ZIP / Postal Code</label>
                                            <input type="text" class="form-control" name="zip" value="{{ old('zip') }}" placeholder="1234">
                                            @error('zip') <small class="text-danger mt-1 d-block fw-bold">{{ $message }}</small> @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">State / Division</label>
                                            <input type="text" class="form-control" name="state" value="{{ old('state') }}" placeholder="e.g. Dhaka">
                                            @error('state') <small class="text-danger mt-1 d-block fw-bold">{{ $message }}</small> @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">City</label>
                                            <input type="text" class="form-control" name="city" value="{{ old('city') }}" placeholder="e.g. Mirpur">
                                            @error('city') <small class="text-danger mt-1 d-block fw-bold">{{ $message }}</small> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">House / Building Name</label>
                                            <input type="text" class="form-control" name="address" value="{{ old('address') }}" placeholder="House #12, Road #5">
                                            @error('address') <small class="text-danger mt-1 d-block fw-bold">{{ $message }}</small> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Road Name / Area</label>
                                            <input type="text" class="form-control" name="locality" value="{{ old('locality') }}" placeholder="Block-C, Banani">
                                            @error('locality') <small class="text-danger mt-1 d-block fw-bold">{{ $message }}</small> @enderror
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label">Nearby Landmark</label>
                                            <input type="text" class="form-control" name="landmark" value="{{ old('landmark') }}" placeholder="e.g. Beside City Hospital">
                                            @error('landmark') <small class="text-danger mt-1 d-block fw-bold">{{ $message }}</small> @enderror
                                        </div>

                                        <div class="col-12 mt-5">
                                            <button type="submit" class="btn-save-address">
                                                SAVE NEW ADDRESS
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuLinks = document.querySelectorAll('.menu-link_us-s');
            menuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    menuLinks.forEach(item => item.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
@endpush
