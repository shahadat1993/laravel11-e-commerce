@extends('layouts.admin')

@section('content')
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap');

            .main-content-inner {
                font-family: 'Plus Jakarta Sans', sans-serif;
                background: #f4f7fa;
                padding: 40px 25px;
            }

            .page-title {
                font-size: 32px !important;
                font-weight: 800;
                background: linear-gradient(to right, #0f172a, #4f46e5);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                letter-spacing: -1px;
            }

            .wg-box {
                background: #ffffff;
                border-radius: 35px;
                padding: 45px;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.03);
                border: 1px solid #edf2f7;
            }

            /* ব্যাক বাটন ডিজাইন */
            .btn-back {
                background: #fff;
                color: #64748b !important;
                padding: 10px 20px;
                border-radius: 12px;
                font-weight: 700;
                display: flex;
                align-items: center;
                gap: 8px;
                border: 1.5px solid #e2e8f0;
                transition: 0.3s all;
                text-decoration: none;
            }
            .btn-back:hover {
                background: #f8fafc;
                color: #4f46e5 !important;
                border-color: #4f46e5;
                transform: translateX(-5px);
            }

            /* ফিল্ডসেট এবং ইনপুট ডিজাইন */
            fieldset { margin-bottom: 28px; border: none; }
            .body-title {
                font-weight: 700;
                color: #475569;
                margin-bottom: 12px;
                font-size: 14px;
                display: flex;
                align-items: center;
                gap: 10px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            input[type="text"],
            input[type="number"],
            input[type="date"],
            select {
                width: 100%;
                padding: 16px 22px !important;
                border-radius: 18px !important;
                border: 2px solid #f1f5f9 !important;
                background: #fcfdfe !important;
                transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                font-weight: 600;
                color: #1e293b;
            }

            input:focus, select:focus {
                border-color: #4f46e5 !important;
                background: #fff !important;
                box-shadow: 0 10px 25px rgba(79, 70, 229, 0.1) !important;
                outline: none;
            }

            /* আইকন এনিমেশন */
            .body-title i {
                font-size: 20px;
                color: #4f46e5;
                background: #f0f0ff;
                width: 35px;
                height: 35px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 10px;
                transition: 0.4s ease;
            }
            fieldset:hover .body-title i {
                background: #4f46e5;
                color: #fff;
                transform: rotate(-10deg) scale(1.1);
            }

            /* সেভ কুপন বাটন ফিক্স */
            .btn-save-coupon {
                background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
                color: white !important;
                padding: 18px 40px;
                border-radius: 20px;
                font-weight: 800;
                border: none;
                cursor: pointer;
                transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                box-shadow: 0 12px 24px rgba(79, 70, 229, 0.25);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 12px;
                white-space: nowrap; /* এক লাইনে রাখার জন্য */
            }
            .btn-save-coupon:hover {
                transform: translateY(-4px);
                box-shadow: 0 18px 35px rgba(79, 70, 229, 0.35);
                filter: brightness(1.1);
            }
            .btn-save-coupon i { font-size: 22px; }

            .text-danger {
                font-size: 13px;
                font-weight: 700;
                color: #ef4444;
                margin-top: 8px;
                display: block;
            }

            @media (max-width: 768px) {
                .wg-box { padding: 30px 20px; }
                .btn-save-coupon { width: 100%; }
            }
        </style>
    @endpush

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h3 class="page-title">Coupon Information</h3>
                    <div class="flex items-center gap-2 text-slate-400 font-semibold mt-1">
                        <a href="{{ route('admin.index') }}">Admin</a> <i class="ri-arrow-right-s-line"></i>
                        <a href="{{ route('admin.coupon') }}">Coupons</a> <i class="ri-arrow-right-s-line"></i>
                        <span class="text-indigo-600">New Coupon</span>
                    </div>
                </div>
                <a href="{{ route('admin.coupon') }}" class="btn-back">
                    <i class="ri-arrow-left-line"></i> Back to List
                </a>
            </div>

            <div class="wg-box">
                <form class="form-new-product" method="POST" action="{{ route('admin.coupon.store') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <fieldset>
                                <div class="body-title"><i class="ri-coupon-3-fill"></i> Coupon Code <span class="text-danger">*</span></div>
                                <input type="text" placeholder="e.g. SUMMER2026" name="code" value="{{ old('code') }}" required>
                                @error('code') <p class="text-danger">{{ $message }}</p> @enderror
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <fieldset>
                                <div class="body-title"><i class="ri-settings-5-fill"></i> Coupon Type</div>
                                <select name="type">
                                    <option value="" disabled selected>Select discount type</option>
                                    <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed Amount ($)</option>
                                    <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Percentage (%)</option>
                                </select>
                                @error('type') <p class="text-danger">{{ $message }}</p> @enderror
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <fieldset>
                                <div class="body-title"><i class="ri-percent-fill"></i> Discount Value <span class="text-danger">*</span></div>
                                <input type="number" placeholder="Enter value" name="value" value="{{ old('value') }}" required>
                                @error('value') <p class="text-danger">{{ $message }}</p> @enderror
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <fieldset>
                                <div class="body-title"><i class="ri-shopping-bag-3-fill"></i> Minimum Cart Value <span class="text-danger">*</span></div>
                                <input type="number" placeholder="Enter min. cart value" name="cart_value" value="{{ old('cart_value') }}" required>
                                @error('cart_value') <p class="text-danger">{{ $message }}</p> @enderror
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <fieldset>
                                <div class="body-title"><i class="ri-calendar-check-fill"></i> Expiry Date <span class="text-danger">*</span></div>
                                <input type="date" name="expiry_date" value="{{ old('expiry_date') }}" required>
                                @error('expiry_date') <p class="text-danger">{{ $message }}</p> @enderror
                            </fieldset>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end">
                        <button class="btn-save-coupon" type="submit">
                            <i class="ri-checkbox-circle-fill"></i> Save Coupon
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
