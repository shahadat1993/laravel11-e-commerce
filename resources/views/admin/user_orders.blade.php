@extends('layouts.admin')

@push('styles')
    <style>
        /* Table responsive container */
        .table-container {
            overflow-x: auto;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        /* Table styling */
        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
        }

        /* Table header */
        .table thead th {
            background-color: #1e293b;
            /* dark blue-gray */
            color: #ffffff;
            font-weight: 700;
            text-align: center;
            padding: 14px 12px;
            border-bottom: 2px solid #3b82f6;
            border-radius: 8px 8px 0 0;
        }

        /* Table body */
        .table tbody td {
            text-align: center;
            padding: 12px 10px;
            border-bottom: 1px solid #e2e8f0;
            transition: background-color 0.3s, transform 0.2s;
        }

        /* Hover effect */
        .table tbody tr:hover {
            background-color: #f1f5f9;
            transform: translateY(-2px);
        }

        /* Status badges */
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 13px;
            text-transform: capitalize;
        }



        /* Back button */
        .back-btn {
            background-color: #1e293b;
            color: #fff;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .back-btn:hover {
            background-color: #3b82f6;
            color: #ffffff;
        }

        /* Responsive for small devices */
        @media (max-width: 768px) {
            .table thead {
                display: none;
            }

            .table tbody td {
                display: block;
                width: 100%;
                text-align: right;
                padding-left: 50%;
                position: relative;
                border-bottom: 1px solid #e2e8f0;
            }

            .table tbody td::before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                width: 45%;
                font-weight: 600;
                text-align: left;
            }

            .table tbody tr {
                margin-bottom: 12px;
                display: block;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
                border-radius: 8px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="main-content-inner p-6">

        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800">Orders of {{ $user->name }}</h3>
            <a href="{{ route('admin.profile.show') }}" class="back-btn">Back to Users</a>
        </div>

        <div class="table-container rounded shadow overflow-hidden">
            <table class="table table-striped min-w-full">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order ID</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($user->orders as $key => $order)
                        <tr>
                            <td data-label="#"> {{ $key + 1 }} </td>
                            <td data-label="Order ID"> {{ $order->id }} </td>
                            <td data-label="Total Amount"> ${{ $order->total }} </td>
                            <td data-label="Status">
                                @switch(strtolower($order->status))
                                    @case('pending')
                                        <span class="badge bg-warning text-uppercase
 text-dark">{{ $order->status }}</span>
                                    @break

                                    @case('completed')
                                        <span class="badge bg-success">{{ $order->status }}</span>
                                    @break

                                    @case('cancelled')
                                        <span class="badge bg-danger">{{ $order->status }}</span>
                                    @break

                                    @default
                                        <span class="badge bg-secondary">{{ $order->status }}</span>
                                @endswitch
                            </td>



                            <td data-label="Created At"> {{ $order->created_at->format('d M, Y H:i A') }} </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500 py-6">No orders found for this user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    @endsection
