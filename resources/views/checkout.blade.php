@php
    use Illuminate\Support\Facades\Session;
@endphp
@extends('layouts.app')

@section('content')
    <style>
        /* Premium Typography & Global Styles */
        .checkout-container {
            padding-top: 50px;
            padding-bottom: 80px;
            background-color: #ffffff;
            color: #2d3436;
        }

        .page-title {
            font-size: 32px;
            font-weight: 800;
            color: #111;
            margin-bottom: 40px;
        }

        /* Checkout Steps Improvement */
        .checkout-steps {
            border-bottom: 1px solid #f1f1f1;
            padding-bottom: 30px;
        }

        .checkout-steps__item {
            opacity: 0.5;
            transition: 0.3s;
        }

        .checkout-steps__item.active {
            opacity: 1;
        }

        .checkout-steps__item-title span {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            color: #111;
        }

        .checkout-steps__item-title em {
            font-size: 12px;
            color: #777;
            font-style: normal;
            display: block;
        }

        .checkout-steps__item-number {
            font-size: 13px;
            font-weight: 700;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 2px solid #ddd;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
        }

        .active .checkout-steps__item-number {
            background: #000;
            border-color: #000;
            color: #fff;
        }

        /* Card & Section Styling */
        .checkout-card {
            border: none;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            border: 1px solid #f0f0f0;
        }

        .card-title-custom {
            font-size: 18px;
            font-weight: 700;
            color: #111;
            padding: 25px 30px;
            border-bottom: 1px solid #f8f8f8;
            margin-bottom: 0;
        }

        .card-body-custom {
            padding: 30px;
        }

        /* Form Elements */
        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #636e72;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            height: 50px;
            border-radius: 10px;
            border: 1px solid #e1e8ed;
            padding: 10px 18px;
            font-size: 15px;
            background-color: #fbfbfb;
            transition: all 0.2s ease-in-out;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: #111;
            box-shadow: 0 0 0 4px rgba(0, 0, 0, 0.03);
            outline: none;
        }

        /* Order Summary & Pricing Text Sizes */
        .summary-table th {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #999;
            padding-bottom: 15px;
        }

        .summary-table td {
            font-size: 15px;
            font-weight: 500;
            padding: 12px 0;
            color: #111;
        }

        .price-label {
            font-size: 15px;
            color: #636e72;
        }

        .price-value {
            font-size: 15px;
            font-weight: 700;
            color: #111;
        }

        .discount-value {
            color: #eb4d4b;
        }

        .total-row {
            border-top: 1px solid #eee;
            margin-top: 15px;
            padding-top: 20px;
        }

        .total-label {
            font-size: 18px;
            font-weight: 800;
            color: #111;
        }

        .total-amount {
            font-size: 22px;
            font-weight: 800;
            color: #111;
        }

        /* Payment Option Box */
        .payment-method-box {
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 12px;
            transition: 0.2s;
            cursor: pointer;
        }

        .payment-method-box:hover {
            border-color: #111;
            background: #fcfcfc;
        }

        .form-check-input:checked~.form-check-label {
            font-weight: 700;
            color: #111;
        }

        .btn-place-order {
            background: #111;
            color: #fff;
            width: 100%;
            border: none;
            padding: 18px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.5px;
            transition: 0.3s;
            margin-top: 20px;
        }

        .btn-place-order:hover {
            background: #333;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
    </style>

    <main class="pt-90 checkout-container">
        <section class="container">
            <h2 class="page-title">Shipping & Checkout</h2>

            {{-- Checkout Steps --}}
            <div class="checkout-steps mb-5 d-flex justify-content-between">
                <a href="{{ route('cart') }}" class="checkout-steps__item active text-decoration-none">
                    <span class="checkout-steps__item-number">01</span>
                    <span class="checkout-steps__item-title">
                        <span>Shopping Bag</span>
                        <em>Manage Items</em>
                    </span>
                </a>
                <a href="{{ route('cart.checkout') }}" class="checkout-steps__item active text-decoration-none">
                    <span class="checkout-steps__item-number">02</span>
                    <span class="checkout-steps__item-title">
                        <span>Shipping</span>
                        <em>Address & Info</em>
                    </span>
                </a>
                <span class="checkout-steps__item">
                    <span class="checkout-steps__item-number">03</span>
                    <span class="checkout-steps__item-title">
                        <span>Confirmation</span>
                        <em>Final Review</em>
                    </span>
                </span>
            </div>

            <form action="{{ route('cart.place.an.order') }}" method="POST">
                @csrf
                <div class="row gx-lg-5">
                    {{-- SHIPPING DETAILS --}}
                    <div class="col-lg-7">
                        <div class="checkout-card mb-4">
                            <h5 class="card-title-custom">Shipping Details</h5>
                            <div class="card-body-custom">
                                @if ($address)
                                    <div class="p-4 rounded-4 bg-light border-0 position-relative mb-2">
                                        <h6 class="fw-bold mb-2" style="font-size: 16px;">{{ $address->name }} <i
                                                class="fa fa-check-circle text-success ms-1"></i></h6>
                                        <div class="text-muted" style="font-size: 14px; line-height: 1.6;">
                                            <p class="mb-0">{{ $address->address }}, {{ $address->locality }}</p>
                                            <p class="mb-0">{{ $address->landmark }}</p>
                                            <p class="mb-0">{{ $address->city }}, {{ $address->state }} -
                                                {{ $address->zip }}</p>
                                            <p class="mb-0 mt-2 text-dark fw-bold">Phone: {{ $address->phone }}</p>
                                        </div>
                                        <a href="{{ route('checkout.address.edit', $address->id) }}"
                                            class="btn btn-sm btn-dark px-3 position-absolute top-0 end-0 mt-4 me-4"
                                            style="border-radius: 8px;">Edit</a>
                                    </div>
                                @else
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label">Full Name *</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name') }}" required placeholder="e.g. John Doe">
                                            @error('name')
                                                <p class="text-danger small mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Phone Number *</label>
                                            <input type="text" class="form-control" name="phone"
                                                value="{{ old('phone') }}" required placeholder="e.g. 017xxxxxxxx">
                                            @error('phone')
                                                <p class="text-danger small mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">ZIP Code *</label>
                                            <input type="text" class="form-control" name="zip"
                                                value="{{ old('zip') }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">State *</label>
                                            <input type="text" class="form-control" name="state"
                                                value="{{ old('state') }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">City *</label>
                                            <input type="text" class="form-control" name="city"
                                                value="{{ old('city') }}" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">House no, Building Name *</label>
                                            <input type="text" class="form-control" name="address"
                                                value="{{ old('address') }}" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Road Name, Area, Colony *</label>
                                            <input type="text" class="form-control" name="locality"
                                                value="{{ old('locality') }}" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Landmark *</label>
                                            <input type="text" class="form-control" name="landmark"
                                                value="{{ old('landmark') }}" required>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- ORDER SUMMARY --}}
                    <div class="col-lg-5">
                        <div class="checkout-card sticky-top" style="top: 20px;">
                            <h5 class="card-title-custom">Order Summary</h5>
                            <div class="card-body-custom">
                                <table class="table table-borderless summary-table mb-2">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (Cart::instance('cart') as $item)
                                            <tr>
                                                <td style="max-width: 200px;">{{ $item->name }} <span
                                                        class="text-muted fw-normal ms-1">×{{ $item->qty }}</span></td>
                                                <td class="text-end fw-bold">${{ $item->subtotal() }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="border-top pt-3">
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="price-label">Subtotal</span>
                                        <span class="price-value">${{ Cart::instance('cart')->subtotal() }}</span>
                                    </div>

                                    @if (Session::has('discounts'))
                                        <div class="d-flex justify-content-between mb-3">
                                            <span class="price-label">Discount
                                                ({{ Session::get('coupon')['code'] }})</span>
                                            <span
                                                class="price-value discount-value">-${{ Session::get('discounts')['discount'] }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <span class="price-label">Subtotal After Discount</span>
                                            <span
                                                class="price-value text-success">${{ Session::get('discounts')['subtotal'] }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <span class="price-label">Shipping</span>
                                            <span class="price-value text-success">Free Shipping</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <span class="price-label">VAT</span>
                                            <span class="price-value">${{ Session::get('discounts')['tax'] }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between total-row">
                                            <span class="total-label">Total Amount</span>
                                            <span class="total-amount">${{ Session::get('discounts')['total'] }}</span>
                                        </div>
                                    @else
                                        <div class="d-flex justify-content-between mb-3">
                                            <span class="price-label">Shipping</span>
                                            <span class="price-value text-success">Free Shipping</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <span class="price-label">VAT</span>
                                            <span class="price-value">$19</span>
                                        </div>
                                        <div class="d-flex justify-content-between total-row">
                                            <span class="total-label">Total Amount</span>
                                            <span class="total-amount">${{ Cart::instance('cart')->total() }}</span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Payment Methods --}}
                                <div class="mt-5">
                                    <label class="form-label mb-3">Payment Method</label>
                                    <div class="payment-method-box">
                                        <div class="form-check m-0">
                                            <input class="form-check-input" type="radio" name="mode" id="mode1"
                                                value="card" checked>
                                            <label class="form-check-label ms-2" for="mode1">Credit or Debit
                                                Card</label>
                                        </div>
                                    </div>
                                    <div class="payment-method-box">
                                        <div class="form-check m-0">
                                            <input class="form-check-input" type="radio" name="mode" id="mode2"
                                                value="paypal">
                                            <label class="form-check-label ms-2" for="mode2">PayPal Express</label>
                                        </div>
                                    </div>
                                    <div class="payment-method-box">
                                        <div class="form-check m-0">
                                            <input class="form-check-input" type="radio" name="mode" id="mode3"
                                                value="cod">
                                            <label class="form-check-label ms-2" for="mode3">Cash on Delivery</label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn-place-order shadow-sm">PLACE ORDER NOW</button>
                                    <p class="text-center mt-3 text-muted" style="font-size: 12px;">
                                        <i class="fa fa-lock me-1"></i> Your transaction is secure and encrypted.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
@endsection
