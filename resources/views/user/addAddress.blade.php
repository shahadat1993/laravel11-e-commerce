@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Addresses</h2>
            <div class="row">
                <div class="col-lg-3">
                    <ul class="account-nav">
                        <li><a href="{{ route('user.index') }}" class="menu-link menu-link_us-s">Dashboard</a></li>
                        <li><a href="{{ route('user.orders') }}" class="menu-link menu-link_us-s">Orders</a></li>
                        <li><a href="{{ route('user.address') }}" class="menu-link menu-link_us-s">Addresses</a></li>
                        <li><a href="{{ route('user.account.details') }}" class="menu-link menu-link_us-s">Account
                                Details</a></li>
                        <li><a href="{{ route('user.wishlist') }}" class="menu-link menu-link_us-s">Wishlist</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="post" id="logout-form">
                                @csrf
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit()"
                                    class="menu-link menu-link_us-s">Logout</a>
                            </form>
                        </li>
                    </ul>


                </div>
                <div class="col-lg-9">

                    <div class="page-content my-account__address">
                        <div class="row">
                            <div class="col-6">
                                <p class="notice">The following addresses will be used on the checkout page by default.</p>
                            </div>
                            <div class="col-6 text-right ">
                                <a href="{{ route('user.address') }}" class="btn btn-sm btn-info">Back</a>
                            </div>
                        </div>
                        <form name="checkout-form" action="{{ route('user.address.store') }}" method="POST">
                            @csrf
                            <div class="row mt-5">
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="name" required=""
                                            value="{{ old('name') }}">
                                        <label for="name">Full Name *</label>
                                        @error('name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="phone"
                                            value="{{ old('phone') }}" required="">
                                        <label for="phone">Phone Number *</label>
                                        @error('phone')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="zip"
                                            value="{{ old('zip') }}" required="">
                                        <label for="zip">Pincode *</label>
                                        @error('zip')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mt-3 mb-3">
                                        <input type="text" class="form-control" name="state"
                                            value="{{ old('state') }}" required="">
                                        <label for="state">State *</label>
                                        @error('state')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="city"
                                            value="{{ old('city') }}" required="">
                                        <label for="city">Town / City *</label>
                                        @error('city')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="address"
                                            value="{{ old('address') }}" required="">
                                        <label for="address">House no, Building Name *</label>
                                        @error('address')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="locality"
                                            value="{{ old('locality') }}" required="">
                                        <label for="locality">Road Name, Area, Colony *</label>
                                        @error('locality')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="landmark"
                                            value="{{ old('landmark') }}" required="">
                                        <label for="landmark">Landmark *</label>
                                        @error('landmark')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-checkout">Add Address</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
