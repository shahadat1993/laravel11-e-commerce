@php
    use Illuminate\Support\Facades\Session;
@endphp
@extends('layouts.app')

@section('content')
<style>
    /* Premium Look & Typography (আগের চেকআউট ডিজাইনের সাথে মিল রেখে) */
    .checkout-container { padding-top: 50px; padding-bottom: 80px; background-color: #ffffff; color: #2d3436; }
    .page-title { font-size: 30px; font-weight: 800; color: #111; margin-bottom: 40px; }

    .checkout-steps__item-number { font-size: 13px; font-weight: 700; width: 28px; height: 28px; border-radius: 50%; border: 2px solid #ddd; display: inline-flex; align-items: center; justify-content: center; margin-right: 12px; }
    .active .checkout-steps__item-number { background: #000; border-color: #000; color: #fff; }

    .checkout-card { border-radius: 16px; background: #fff; box-shadow: 0 10px 30px rgba(0,0,0,0.04); border: 1px solid #f0f0f0; }
    .card-title-custom { font-size: 18px; font-weight: 700; color: #111; padding: 25px 30px; border-bottom: 1px solid #f8f8f8; margin-bottom: 0; }
    .card-body-custom { padding: 30px; }

    .form-label { font-size: 13px; font-weight: 600; color: #636e72; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-control {
        height: 50px; border-radius: 10px; border: 1px solid #e1e8ed; padding: 10px 18px;
        font-size: 15px; background-color: #fbfbfb; transition: all 0.2s ease;
    }
    .form-control:focus { background-color: #fff; border-color: #111; outline: none; box-shadow: 0 0 0 4px rgba(0,0,0,0.03); }

    /* Summary Table Styling */
    .summary-table th { font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #999; padding-bottom: 15px; }
    .summary-table td { font-size: 15px; font-weight: 500; padding: 12px 0; color: #111; }
    .price-label { font-size: 15px; color: #636e72; }
    .price-value { font-size: 15px; font-weight: 700; color: #111; }
    .total-row { border-top: 1px solid #eee; margin-top: 15px; padding-top: 20px; }
    .total-label { font-size: 18px; font-weight: 800; color: #111; }
    .total-amount { font-size: 22px; font-weight: 800; color: #111; }

    .btn-update { background: #111; color: #fff; border: none; padding: 15px 40px; border-radius: 10px; font-weight: 700; transition: 0.3s; }
    .btn-update:hover { background: #333; transform: translateY(-2px); }
</style>

<main class="pt-90 checkout-container">
    <section class="container">
        <h2 class="page-title">Edit Shipping Address</h2>

        {{-- Steps --}}
        <div class="checkout-steps mb-5 d-flex justify-content-between">
            <a href="{{ route('cart') }}" class="checkout-steps__item active text-decoration-none text-dark">
                <span class="checkout-steps__item-number">01</span>
                <span class="checkout-steps__item-title"><span>Shopping Bag</span></span>
            </a>
            <a href="{{ route('cart.checkout') }}" class="checkout-steps__item active text-decoration-none text-dark">
                <span class="checkout-steps__item-number">02</span>
                <span class="checkout-steps__item-title"><span>Shipping</span></span>
            </a>
            <span class="checkout-steps__item">
                <span class="checkout-steps__item-number">03</span>
                <span class="checkout-steps__item-title"><span>Confirmation</span></span>
            </span>
        </div>

        <form action="{{ route('checkout.address.update', $address->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row gx-lg-5">
                {{-- LEFT SIDE: EDIT FORM --}}
                <div class="col-lg-7">
                    <div class="checkout-card mb-4">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                            <h5 class="mb-0 fw-bold" style="font-size: 18px;">Edit Address Details</h5>
                            <a href="{{ route('cart.checkout') }}" class="btn btn-sm btn-outline-secondary px-3">Back</a>
                        </div>
                        <div class="card-body-custom">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name', $address->name) }}" required>
                                    @error('name') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number *</label>
                                    <input type="text" class="form-control" name="phone" value="{{ old('phone', $address->phone) }}" required>
                                    @error('phone') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">ZIP Code *</label>
                                    <input type="text" class="form-control" name="zip" value="{{ old('zip', $address->zip) }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">State *</label>
                                    <input type="text" class="form-control" name="state" value="{{ old('state', $address->state) }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">City *</label>
                                    <input type="text" class="form-control" name="city" value="{{ old('city', $address->city) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">House no, Building Name *</label>
                                    <input type="text" class="form-control" name="address" value="{{ old('address', $address->address) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Road Name, Area, Colony *</label>
                                    <input type="text" class="form-control" name="locality" value="{{ old('locality', $address->locality) }}" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Landmark *</label>
                                    <input type="text" class="form-control" name="landmark" value="{{ old('landmark', $address->landmark) }}" required>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn-update">UPDATE ADDRESS</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT SIDE: ORDER SUMMARY (Styled Same as Checkout) --}}
                <div class="col-lg-5">
                    <div class="checkout-card sticky-top" style="top: 20px;">
                        <h5 class="card-title-custom">Your Order Summary</h5>
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
                                            <td class="text-muted">{{ $item->name }} <span class="fw-bold text-dark">×{{ $item->qty }}</span></td>
                                            <td class="text-end fw-bold">${{ $item->subtotal() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="border-top pt-3">
                                @if (Session::has('discounts'))
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="price-label">Subtotal</span>
                                        <span class="price-value">${{ Cart::instance('cart')->subtotal() }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="price-label">Discount</span>
                                        <span class="price-value text-danger">-${{ Session::get('discounts')['discount'] }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="price-label">Subtotal After Discount</span>
                                        <span class="price-value text-success">${{ Session::get('discounts')['subtotal'] }}</span>
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
                                        <span class="price-label">Subtotal</span>
                                        <span class="price-value">${{ Cart::instance('cart')->subtotal() }}</span>
                                    </div>
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

                            <div class="alert alert-warning mt-4 border-0 small shadow-sm" style="background-color: #fff9eb; color: #856404; border-radius: 12px;">
                                <i class="fa fa-info-circle me-2"></i> After updating your address, you can proceed to final confirmation and payment.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</main>
@endsection
