@extends('layouts.admin')

@section('content')
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap');

            .main-content-inner {
                font-family: 'Plus Jakarta Sans', sans-serif;
                background: #f0f2f5;
                padding: 40px 25px;
            }

            .page-title {
                font-size: 32px !important;
                font-weight: 800;
                background: linear-gradient(to right, #1e293b, #4f46e5);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                letter-spacing: -1px;
            }

            /* কার্ড স্টাইল */
            .wg-box {
                background: #ffffff;
                border-radius: 25px;
                padding: 30px;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
                border: 1px solid #f1f5f9;
                margin-bottom: 30px;
                transition: 0.3s;
            }

            .wg-box:hover { transform: translateY(-5px); }

            h5 {
                font-weight: 800;
                color: #1e293b;
                font-size: 20px;
                margin-bottom: 25px;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            h5::before {
                content: '';
                width: 5px;
                height: 25px;
                background: #4f46e5;
                border-radius: 10px;
                display: inline-block;
            }

            /* টেবিল ডিজাইন */
            .table { border-radius: 15px; overflow: hidden; border: none !important; }
            .table thead th {
                background: #f8fafc;
                color: #64748b;
                font-weight: 700;
                text-transform: uppercase;
                font-size: 12px;
                padding: 15px;
                border: none;
            }
            .table td { padding: 18px 15px; vertical-align: middle; border-color: #f1f5f9; font-size: 14px; }

            /* স্ট্যাটাস ব্যাজ */
            .badge { padding: 8px 15px; border-radius: 10px; font-weight: 700; }
            .bg-success { background: #dcfce7 !important; color: #15803d !important; }
            .bg-danger { background: #fee2e2 !important; color: #b91c1c !important; }
            .bg-warning { background: #fef9c3 !important; color: #a16207 !important; }
            .bg-secondary { background: #f1f5f9 !important; color: #475569 !important; }

            /* প্রোডাক্ট ইমেজ */
            .pname { display: flex; align-items: center; gap: 15px; }
            .pname img {
                width: 60px;
                height: 60px;
                object-fit: cover;
                border-radius: 12px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            }

            /* বাটন ডিজাইন */
            .tf-button {
                padding: 12px 25px;
                border-radius: 12px;
                font-weight: 700;
                transition: 0.4s;
                border: none;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                gap: 8px;
            }
            .style-1 { background: #4f46e5; color: white !important; }
            .style-1:hover { background: #3730a3; transform: scale(1.05); }

            /* শিপিং অ্যাড্রেস কার্ড */
            .address-card {
                background: #f8fafc;
                padding: 25px;
                border-radius: 20px;
                border-left: 5px solid #4f46e5;
            }
            .address-card p { margin-bottom: 5px; color: #475569; font-weight: 500; }

            /* সিলেক্ট অপশন */
            select.p-3 {
                width: 100%;
                border-radius: 12px;
                border: 2px solid #e2e8f0;
                font-weight: 600;
                appearance: none;
                background: url("data:image/svg+xml,...") no-repeat right 15px center;
            }

            /* এনিমেটেড ডাউনলোড লিংক */
            .download-link {
                color: #4f46e5 !important;
                font-weight: 800;
                display: flex;
                align-items: center;
                gap: 5px;
                text-decoration: none;
                transition: 0.3s;
            }
            .download-link:hover { transform: translateY(-2px); color: #3730a3 !important; }

            @media (max-width: 768px) {
                .col-md-6, .col-3 { width: 100% !important; margin-bottom: 15px; }
            }
        </style>
    @endpush

    <div class="main-content-inner">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h3 class="page-title">Order Intelligence</h3>
                <div class="flex items-center gap-2 text-slate-500 font-medium mt-1">
                    <span>Admin</span> <i class="ri-arrow-right-s-line"></i> <span>Order #{{ $order->id }}</span>
                </div>
            </div>
            <a href="{{ route('admin.orders') }}" class="tf-button style-1">
                <i class="ri-arrow-left-line"></i> Back to Orders
            </a>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="wg-box">
                    <h5><i class="ri-information-line"></i> Ordered Details</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="bg-light text-center">Order No</th>
                                    <td class="font-bold text-primary">#{{ $order->id }}</td>
                                    <th class="bg-light text-center">Mobile</th>
                                    <td>{{ $order->phone }}</td>
                                    <th class="bg-light text-center">Zip Code</th>
                                    <td>{{ $order->zip }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light text-center">Order Date</th>
                                    <td>{{ $order->created_at }}</td>
                                    <th class="bg-light text-center">Delivery Date</th>
                                    <td>{{ $order->delivered_date ?? 'N/A' }}</td>
                                    <th class="bg-light text-center">Canceled Date</th>
                                    <td>{{ $order->canceled_date ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light text-center">Order Status</th>
                                    <td colspan="5">
                                        @if ($order->status == 'delivered')
                                            <span class="badge bg-success"><i class="ri-checkbox-circle-line"></i> Delivered</span>
                                        @elseif ($order->status == 'canceled')
                                            <span class="badge bg-danger"><i class="ri-close-circle-line"></i> Canceled</span>
                                        @else
                                            <span class="badge bg-warning"><i class="ri-time-line"></i> Ordered</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="wg-box">
                    <h5><i class="ri-shopping-bag-3-line"></i> Ordered Items</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product Details</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">SKU</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Brand</th>
                                    <th class="text-center">Invoice</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderItems as $item)
                                    <tr>
                                        <td>
                                            <div class="pname">
                                                <img src="{{ asset('uploads/products/' . $item->product->image) }}" alt="">
                                                <div>
                                                    <a href="{{ route('shop.details', $item->product->slug) }}" target="_blank" class="font-bold text-dark">{{ $item->product->name }}</a>
                                                    <div class="text-xs text-slate-400">Option: {{ $item->options ?? 'None' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center font-bold text-indigo-600">${{ $item->price }}</td>
                                        <td class="text-center font-bold">{{ $item->quantity }}</td>
                                        <td class="text-center font-medium">{{ $item->product->sku }}</td>
                                        <td class="text-center"><span class="bg-slate-100 px-2 py-1 rounded text-xs">{{ $item->product->category->name }}</span></td>
                                        <td class="text-center text-slate-500">{{ $item->product->brand->name }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('invoice.download', $order->id) }}" class="download-link">
                                                <i class="ri-file-download-line text-xl"></i> Download
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $orderItems->links('pagination::bootstrap-5') }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="wg-box h-full">
                            <h5><i class="ri-map-pin-user-line"></i> Shipping Address</h5>
                            <div class="address-card">
                                <p class="font-bold text-lg text-dark mb-2">{{ $order->name }}</p>
                                <p><i class="ri-map-pin-line"></i> {{ $order->address }}, {{ $order->locality }}</p>
                                <p>{{ $order->city }}, {{ $order->country }} - {{ $order->zip }}</p>
                                <p class="mt-3"><strong>Landmark:</strong> {{ $order->landmark }}</p>
                                <p class="mt-2 text-primary"><strong>Phone:</strong> {{ $order->phone }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="wg-box h-full">
                            <h5><i class="ri-bank-card-line"></i> Transactions</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th class="bg-light text-center">Subtotal</th>
                                        <td class="font-bold">${{ $order->subtotal }}</td>
                                        <th class="bg-light text-center">Tax</th>
                                        <td>${{ $order->tax }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-center">Discount</th>
                                        <td class="text-danger">-${{ $order->discount }}</td>
                                        <th class="bg-light text-primary text-center">Total</th>
                                        <td class="font-extrabold text-primary text-lg">${{ $order->total }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-center">Method</th>
                                        <td class="font-bold text-uppercase">{{ $transactions->mode }}</td>
                                        <th class="bg-light text-center">Status</th>
                                        <td>
                                            @if ($transactions->status == 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @elseif($transactions->status == 'declined')
                                                <span class="badge bg-danger">Declined</span>
                                            @else
                                                <span class="badge bg-warning">{{ ucfirst($transactions->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="wg-box mt-5">
                    <div class="row g-4">
                        <div class="col-md-6 border-end">
                            <h5><i class="ri-refresh-line"></i> Update Order Status</h5>
                            <form action="{{ route('admin.orders.status.update') }}" method="POST" class="d-flex gap-3 align-items-end">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <div class="flex-grow-1">
                                    <select name="order_status" class="form-control p-3">
                                        <option value="ordered" {{ $order->status == 'ordered' ? 'selected' : '' }}>Ordered</option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                                    </select>
                                </div>
                                <button type="submit" class="tf-button style-1">Update Status</button>
                            </form>
                        </div>

                        <div class="col-md-6">
                            <h5><i class="ri-secure-payment-line"></i> Transaction Status</h5>
                            <form action="{{ route('admin.transaction.status.update') }}" method="POST" class="d-flex gap-3 align-items-end">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <div class="flex-grow-1">
                                    <select name="transaction_status" class="form-control p-3">
                                        <option value="pending" {{ $order->transaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ $order->transaction->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="refunded" {{ $order->transaction->status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                    </select>
                                </div>
                                <button type="submit" class="tf-button style-1">Update Status</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
