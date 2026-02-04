@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <section class="my-account container">
            <h2 class="page-title">Edit Address</h2>

            <div class="row">
                {{-- SIDEBAR --}}
                <div class="col-lg-3">
                    <ul class="account-nav">
                        <li><a href="{{ route('user.index') }}" class="menu-link">Dashboard</a></li>
                        <li><a href="{{ route('user.orders') }}" class="menu-link">Orders</a></li>
                        <li><a href="{{ route('user.address') }}" class="menu-link active">Addresses</a></li>
                        <li><a href="{{ route('user.account.details') }}" class="menu-link">Account Details</a></li>
                        <li><a href="{{ route('user.wishlist') }}" class="menu-link">Wishlist</a></li>
                    </ul>
                </div>

                {{-- CONTENT --}}
                <div class="col-lg-9">
                    <form action="{{ route('user.address.update', $address->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Update Address</h5>
                            </div>

                            <div class="card-body">
                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" name="name" value="{{ old('name', $address->name) }}"
                                            class="form-control">
                                            @error('name')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Phone</label>
                                        <input type="text" name="phone" value="{{ old('phone', $address->phone) }}"
                                            class="form-control">
                                            @error('phone')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">ZIP</label>
                                        <input type="text" name="zip" value="{{ old('zip', $address->zip) }}"
                                            class="form-control">
                                             @error('zip')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">State</label>
                                        <input type="text" name="state" value="{{ old('state', $address->state) }}"
                                            class="form-control">
                                             @error('state')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">City</label>
                                        <input type="text" name="city" value="{{ old('city', $address->city) }}"
                                            class="form-control">
                                             @error('city')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Address</label>
                                        <input type="text" name="address"
                                            value="{{ old('address', $address->address) }}" class="form-control">
                                             @error('address')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Locality</label>
                                        <input type="text" name="locality"
                                            value="{{ old('locality', $address->locality) }}" class="form-control">
                                             @error('locality')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label">Landmark</label>
                                        <input type="text" name="landmark"
                                            value="{{ old('landmark', $address->landmark) }}" class="form-control">
                                             @error('landmark')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="card-footer text-end">
                                <button class="btn btn-primary px-4">Update</button>
                                <a href="{{ route('user.address') }}" class="btn btn-secondary ms-2">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
