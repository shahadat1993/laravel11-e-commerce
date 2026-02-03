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
                            <div class="col-6 text-right">
                                <a href="{{ route('user.address.add') }}" class="btn btn-sm btn-info">Add New</a>
                            </div>
                        </div>
                        @if ($addresses)
                            @foreach ($addresses as $address)
                                <div class="my-account__address-list row mb-3">
                                    <h5>Shipping Address</h5>

                                    <div class="my-account__address-item col-md-6">
                                        <div
                                            class="my-account__address-item__title d-flex justify-content-between align-items-center">
                                            <h5>
                                                {{ $address->name }}
                                                @if ($address->isdefault)
                                                    <i class="fa fa-check-circle text-success"></i>
                                                @endif
                                            </h5>

                                            @if (!$address->isdefault)
                                                <form action="{{ route('user.address.default', $address->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-success"
                                                        style="color: green;">
                                                        Make Default
                                                    </button>
                                                </form>
                                            @else
                                                <span class="badge bg-success" style="color: green;">Default</span>
                                            @endif
                                        </div>

                                        <div class="my-account__address-item__detail">
                                            <p>{{ $address->address }}</p>
                                            <p>{{ $address->landmark }}</p>
                                            <p>{{ $address->city }}, {{ $address->state }}, {{ $address->country }}</p>
                                            <p>{{ $address->zip }}</p>
                                            <p>{{ $address->phone }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No address added yet</p>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
