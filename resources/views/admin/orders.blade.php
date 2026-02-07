@extends('layouts.admin')

@php
    use Illuminate\Support\Str;
    use Carbon\Carbon;
@endphp

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

            /* প্রিমিয়াম হেডার */
            .page-title {
                font-size: 32px !important;
                font-weight: 800;
                background: linear-gradient(to right, #1e293b, #4f46e5);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                letter-spacing: -1px;
            }

            /* মেইন বক্স ডিজাইন */
            .wg-box {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                border-radius: 30px;
                padding: 35px;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05);
                border: 1px solid #ffffff;
            }

            /* মডার্ন সার্চ বার (বক্সের ভেতরে) */
            .inner-search-wrapper {
                position: relative;
                max-width: 350px;
                margin-bottom: 25px;
            }

            .inner-search-wrapper input {
                width: 100%;
                padding: 12px 20px 12px 45px !important;
                border-radius: 15px !important;
                border: 1.5px solid #e2e8f0 !important;
                background: #f8fafc !important;
                font-weight: 600;
                font-size: 14px;
                transition: 0.4s all;
            }

            .inner-search-wrapper input:focus {
                border-color: #4f46e5 !important;
                background: #fff !important;
                box-shadow: 0 8px 20px rgba(79, 70, 229, 0.08) !important;
                outline: none;
            }

            .inner-search-icon {
                position: absolute;
                left: 15px;
                top: 50%;
                transform: translateY(-50%);
                color: #94a3b8;
                font-size: 18px;
            }

            /* টেবিল ডিজাইন */
            .table-responsive {
                border-radius: 20px;
            }

            .table {
                border-collapse: separate;
                border-spacing: 0 12px;
                margin-top: -12px;
            }

            .table thead th {
                background: transparent;
                border: none;
                color: #64748b;
                font-weight: 700;
                text-transform: uppercase;
                font-size: 16px;
                letter-spacing: 1.5px;
                padding: 15px 20px;
            }

            .table tbody tr {
                background: #ffffff;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.02);
                transition: 0.4s ease;
            }

            .table tbody tr:hover {
                transform: translateY(-3px) scale(1.005);
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.06);
            }

            .table td {
                padding: 20px 20px !important;
                border: none;
                vertical-align: middle;
                font-size: 15px;
            }

            .table td:first-child { border-radius: 20px 0 0 20px; }
            .table td:last-child { border-radius: 0 20px 20px 0; }

            /* স্ট্যাটাস ব্যাজ */
            .status-badge {
                padding: 7px 14px;
                border-radius: 10px;
                font-weight: 800;
                font-size: 10px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .status-delivered { background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); color: #166534; }
            .status-canceled { background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); color: #991b1b; }
            .status-ordered { background: linear-gradient(135deg, #fef9c3 0%, #fef08a 100%); color: #854d0e; }

            /* টেক্সট হাইলাইট */
            .price-text { font-weight: 800; color: #1e293b; }
            .total-highlight { color: #4f46e5; font-size: 15px; }

            /* অ্যাকশন বাটন */
            .btn-view {
                width: 44px;
                height: 44px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #f1f5f9;
                color: #4f46e5;
                border-radius: 14px;
                font-size: 20px;
                transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            }

            .btn-view:hover {
                background: #4f46e5;
                color: #fff;
                transform: rotate(15deg) scale(1.15);
                box-shadow: 0 8px 15px rgba(79, 70, 229, 0.2);
            }

            .pagination-container { margin-top: 30px; }
        </style>
    @endpush

    <div class="main-content-inner">
        <div class="mb-10">
            <h3 class="page-title">Orders Management</h3>
            <div class="flex items-center gap-2 text-slate-500 font-medium mt-1">
                <span>Admin</span> <i class="ri-arrow-right-s-line"></i> <span>Orders List</span>
            </div>
        </div>

        <div class="wg-box">
            <div class="inner-search-wrapper">
                <i class="ri-search-2-line inner-search-icon"></i>
                <form class="form-search">
                    <input type="text" placeholder="Search by name or phone..." name="name" value="">
                </form>
            </div>

            <div class="wg-table">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">#No</th>
                                <th>Customer Details</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Subtotal</th>
                                <th class="text-center">Tax</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Items</th>
                                <th class="text-center">Delivered On</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="text-center font-bold text-slate-300">#{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="font-extrabold text-slate-800">{{ $order->name }}</div>
                                        <span class="text-[10px] uppercase font-bold text-slate-400">ID: #{{ 1000 + $order->id }}</span>
                                    </td>
                                    <td class="text-center font-semibold text-slate-600">{{ $order->phone }}</td>
                                    <td class="text-center price-text">${{ $order->subtotal }}</td>
                                    <td class="text-center text-slate-400 font-bold">${{ $order->tax }}</td>
                                    <td class="text-center price-text total-highlight">${{ $order->total }}</td>
                                    <td class="text-center">
                                        @if ($order->status == 'delivered')
                                            <span class="status-badge status-delivered">Delivered</span>
                                        @elseif ($order->status == 'canceled')
                                            <span class="status-badge status-canceled">Canceled</span>
                                        @else
                                            <span class="status-badge status-ordered">Ordered</span>
                                        @endif
                                    </td>
                                    <td class="text-center font-bold text-slate-500">
                                        {{ Carbon::parse($order->created_at)->format('d M, Y') }}
                                    </td>
                                    <td class="text-center">
                                        <span class="bg-indigo-50 text-indigo-600 px-3 py-1 rounded-lg font-extrabold text-xs">
                                            {{ $order->orderItems->count() }}
                                        </span>
                                    </td>
                                    <td class="text-center text-slate-400 font-medium">
                                        {{ $order->delivered_date ? Carbon::parse($order->delivered_date)->format('d M, Y') : '---' }}
                                    </td>
                                    <td class="text-center">
                                        <div class="flex justify-center">
                                            <a href="{{ route('admin.orders.details', $order->id) }}" class="btn-view" title="View Details">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="pagination-container d-flex justify-content-center">
                {{ $orders->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
