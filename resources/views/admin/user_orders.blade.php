@extends('layouts.admin')

@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap');

        .main-wrapper {
            font-family: 'Outfit', sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            padding: 40px 20px;
        }

        /* Header Section */
        .page-header {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            padding: 40px;
            border-radius: 24px;
            margin-bottom: -60px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        /* Table Card Container */
        .table-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
        }

        /* Professional Table Styling */
        .modern-table {
            width: 100%;
            border-spacing: 0 12px;
            border-collapse: separate;
        }

        .modern-table thead th {
            color: #64748b;
            text-transform: uppercase;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 15px 25px;
            text-align: center;
        }

        .modern-table tbody tr {
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            border-radius: 16px;
            transition: all 0.3s ease;
        }

        .modern-table tbody tr:hover {
            transform: translateY(-5px) scale(1.01);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
            background: #f8faff;
        }

        .modern-table tbody td {
            padding: 20px 25px;
            text-align: center;
            color: #334155;
            font-size: 15px;
            border-top: 1px solid #f1f5f9;
            border-bottom: 1px solid #f1f5f9;
        }

        .modern-table tbody td:first-child { border-left: 1px solid #f1f5f9; border-radius: 16px 0 0 16px; }
        .modern-table tbody td:last-child { border-right: 1px solid #f1f5f9; border-radius: 0 16px 16px 0; }

        /* Amount & ID Styling */
        .amount-text {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
        }

        .order-id-badge {
            background: #eef2ff;
            color: #4f46e5;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            border: 1px solid #e0e7ff;
        }

        /* Updated Status Badges */
        .status-badge {
            padding: 8px 18px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 11px;
            display: inline-block;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .bg-ordered { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; } /* Yellow */
        .bg-delivered { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; } /* Green */
        .bg-danger-custom { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; } /* Red */

        /* Enhanced Back Button (The "Return to Profiles") */
        .btn-return {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            color: #ffffff !important;
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-return:hover {
            background: #ffffff;
            color: #0f172a !important;
            transform: translateX(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 992px) {
            .modern-table thead { display: none; }
            .modern-table tbody tr { display: block; margin-bottom: 25px; padding: 15px; }
            .modern-table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 12px 10px;
                border: none !important;
            }
            .modern-table tbody td::before {
                content: attr(data-label);
                font-weight: 700;
                color: #94a3b8;
                font-size: 12px;
            }
        }
    </style>
@endpush

@section('content')
<div class="main-wrapper">
    <div class="container mx-auto">
        <div class="page-header flex flex-col md:flex-row justify-between items-center">
            <div class="text-center md:text-left mb-6 md:mb-0">
                <h2 class="text-4xl font-extrabold text-white mb-2 tracking-tight">Order Insight</h2>
                <p class="text-blue-200 text-lg">Transaction records for <span class="text-yellow-400 font-bold underline">{{ $user->name }}</span></p>
            </div>

            <a href="{{ route('admin.profile.show') }}" class="btn-return">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                </svg>
                Return to Profiles
            </a>
        </div>

        <div class="table-card">
            <div class="overflow-x-auto">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th># Serial</th>
                            <th>Order ID</th>
                            <th>Total Investment</th>
                            <th>Fulfillment Status</th>
                            <th>Creation Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user->orders as $key => $order)
                            <tr>
                                <td data-label="Serial">
                                    <span class="text-slate-400 font-bold">#{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td data-label="Order ID">
                                    <span class="order-id-badge">ORDER-{{ $order->id }}</span>
                                </td>
                                <td data-label="Total Investment">
                                    <span class="amount-text">${{ number_format($order->total, 2) }}</span>
                                </td>
                                <td data-label="Fulfillment Status">
                                    @php
                                        $status = strtolower($order->status);
                                        // Logic based on your requirement
                                        $class = match($status) {
                                            'ordered' => 'bg-ordered',
                                            'delivered' => 'bg-delivered',
                                            default => 'bg-danger-custom',
                                        };
                                    @endphp
                                    <span class="status-badge {{ $class }}">
                                        {{ strtoupper($order->status) }}
                                    </span>
                                </td>
                                <td data-label="Creation Date">
                                    <div class="text-sm">
                                        <p class="font-bold text-slate-700">{{ $order->created_at->format('M d, Y') }}</p>
                                        <p class="text-slate-400 text-xs">{{ $order->created_at->format('h:i A') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-20 text-center">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="mx-auto opacity-20 mb-4">
                                    <p class="text-slate-400 text-lg">No order history available.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
