@extends('layouts.app')
@section('content')
    <style>
        /* জেনারেল পেজ সেটিংস */
        .my-account {
            padding-top: 50px;
            padding-bottom: 80px;
            background-color: #f9f9f9;
        }

        .page-title {
            font-size: 24px;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 15px;
            letter-spacing: -0.5px;
        }

        /* ড্যাশবোর্ড বক্স (wg-box) ডিজাইন */
        .my-account .wg-box {
            padding: 30px;
            border-radius: 15px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            border: 1px solid #f0f0f0;
            margin-bottom: 30px;
        }

        /* টেবিল স্টাইল */
        .table-transaction th,
        .table-transaction td {
            padding: 15px 20px !important;
            vertical-align: middle;
            border: 1px solid #f1f1f1 !important;
        }

        /* টেবিল হেডার (আপনার আগের কালারটি আরও প্রিমিয়াম করা হয়েছে) */
        .table> :not(caption)>tr>th {
            padding: 12px 20px !important;
            background-color: #111 !important;
            /* প্রফেশনাল ডার্ক লুক */
            color: #fff !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
        }

        .table-transaction th {
            background-color: #fcfcfc !important;
            color: #666 !important;
            font-weight: 700;
            width: 15%;
        }

        /* স্ট্যাটাস ব্যাজ */
        .badge {
            padding: 8px 15px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
        }

        .bg-success {
            background-color: #e7f7ef !important;
            color: #0fa457 !important;
        }

        .bg-danger {
            background-color: #fff0f0 !important;
            color: #d93025 !important;
        }

        .bg-warning {
            background-color: #fff8e6 !important;
            color: #f29900 !important;
        }

        /* প্রোডাক্ট ইমেজ এবং নাম */
        .table-striped .image {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #eee;
            background: #fff;
        }

        .pname {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .body-title-2 {
            font-weight: 700;
            color: #111;
            text-decoration: none;
        }

        .body-title-2:hover {
            text-decoration: underline;
        }

        /* অ্যাড্রেস সেকশন */
        .address-detail-card {
            background: #fbfbfb;
            padding: 20px;
            border-radius: 12px;
            border: 1px dashed #ddd;
        }

        .address-detail-card p {
            margin-bottom: 5px;
            font-size: 14px;
            color: #555;
        }

        /* বাটন স্টাইল */
        .btn-primary {
            background: #111;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 700;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background: #333;
            transform: translateY(-2px);
        }

        .btn-danger {
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 700;
        }

        .divider {
            border-top: 1px solid #eee;
            margin: 20px 0;
        }
    </style>

    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Orders Details</h2>
            <div class="row">
                <div class="col-lg-2">
                    @include('user.account-nav')
                </div>

                <div class="col-lg-10">
                    {{-- ১ম বক্স: অর্ডার ডিটেইলস --}}
                    <div class="wg-box">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="m-0 fw-bold">Order Summary</h5>
                            <a class="btn btn-sm btn-primary text-white" href="{{ route('user.orders') }}">Back to List</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-transaction">
                                <tbody>
                                    <tr>
                                        <th>Order No</th>
                                        <td>#{{ $order->id }}</td>
                                        <th>Mobile</th>
                                        <td>{{ $order->phone }}</td>
                                        <th>Zip Code</th>
                                        <td>{{ $order->zip }}</td>
                                    </tr>
                                    <tr>
                                        <th>Order Date</th>
                                        <td>{{ $order->created_at }}</td>
                                        <th>Delivery Date</th>
                                        <td>{{ $order->delivered_date ?? 'N/A' }}</td>
                                        <th>Canceled Date</th>
                                        <td>{{ $order->canceled_date ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Order Status</th>
                                        <td colspan="5">
                                            @if ($order->status == 'delivered')
                                                <span class="badge bg-success">Delivered</span>
                                            @elseif ($order->status == 'canceled')
                                                <span class="badge bg-danger">Canceled</span>
                                            @else
                                                <span class="badge bg-warning">Ordered</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- ২য় বক্স: অর্ডার আইটেমস --}}
                    <div class="wg-box">
                        <h5 class="fw-bold mb-4">Ordered Items</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">SKU</th>
                                        <th class="text-center">Category</th>
                                        <th class="text-center">Brand</th>
                                        <th class="text-center">Return</th>
                                        <th class="text-center">Invoice</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->orderItems as $item)
                                        <tr>
                                            <td class="pname">
                                                <div class="image">
                                                    <img src="{{ asset('uploads/products') . '/' . $item->product->image }}"
                                                        alt="" class="img-fluid">
                                                </div>
                                                <div class="name">
                                                    <a href="{{ route('shop.details', $item->product->slug) }}"
                                                        target="_blank" class="body-title-2">{{ $item->product->name }}</a>
                                                    <div class="small text-muted">{{ $item->options }}</div>
                                                </div>
                                            </td>
                                            <td class="text-center fw-bold">${{ $item->price }}</td>
                                            <td class="text-center fw-bold">{{ $item->quantity }}</td>
                                            <td class="text-center small">{{ $item->product->sku }}</td>
                                            <td class="text-center small">{{ $item->product->category->name }}</td>
                                            <td class="text-center small">{{ $item->product->brand->name }}</td>
                                            <td class="text-center">{{ $item->rstatus == 0 ? 'NO' : 'YES' }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('invoice.download', $order->id) }}"
                                                    class="fw-bold text-primary small">
                                                    <i class="fa fa-download"></i> PDF
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="divider"></div>
                        <div class="d-flex justify-content-center">
                            {{ $orderItems->links('pagination::bootstrap-5') }}
                        </div>
                    </div>

                    <div class="row">
                        {{-- ৩য় বক্স: শিপিং অ্যাড্রেস --}}
                        <div class="col-md-6">
                            <div class="wg-box h-100">
                                <h5 class="fw-bold mb-3">Shipping Address</h5>
                                <div class="address-detail-card">
                                    <p class="fw-bold text-dark">{{ $order->name }}</p>
                                    <p>{{ $order->address }}</p>
                                    <p>{{ $order->locality }}</p>
                                    <p>{{ $order->city }}, {{ $order->country }} - {{ $order->zip }}</p>
                                    <p class="mt-2 fw-bold text-dark">Mobile: {{ $order->phone }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- ৪র্থ বক্স: ট্রানজেকশন --}}
                        <div class="col-md-6">
                            <div class="wg-box h-100">
                                <h5 class="fw-bold mb-3">Transactions Summary</h5>
                                <table class="table table-bordered table-transaction">
                                    <tbody>
                                        <tr>
                                            <th>Subtotal</th>
                                            <td class="fw-bold">${{ $order->subtotal }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tax & Discount</th>
                                            <td class="fw-bold">T: ${{ $order->tax }} | D: -${{ $order->discount }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Amount</th>
                                            <td class="fw-bold text-dark" style="font-size: 18px;">${{ $order->total }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Payment</th>
                                            <td>
                                                {{ $transactions->mode }} -
                                                @if ($transactions->status == 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @else
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- ক্যানসেল বাটন --}}
                    @if ($order->status != 'delivered' && $order->status != 'canceled')
                        <div class="wg-box mt-4 text-center">
                            <form id="cancelOrderForm" action="{{ route('user.orders.cancel') }}" method="POST">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <button type="button" id="cancelOrderBtn" class="btn btn-danger px-5"
                                    data-id="{{ $order->id }}">
                                    Cancel This Order
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection
