@extends('layouts.app')
@section('content')
    <style>
        .my-account {
            padding-top: 60px;
            padding-bottom: 100px;
            background-color: #fcfcfc;
        }

        .page-title {
            font-size: 32px;
            font-weight: 900;
            color: #111;
            margin-bottom: 40px;
            letter-spacing: -1px;
        }

        /* Premium Table Wrapper */
        .order-table-container {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(0, 0, 0, 0.02);
            padding: 15px;
            /* কন্টেইনারের ভেতরে বাড়তি প্যাডিং */
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
            vertical-align: middle;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        /* Table Header */
        .table thead th {
            background-color: transparent !important;
            color: #999 !important;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 1.5px;
            padding: 20px !important;
            border: none !important;
        }

        /* Table Rows */
        .table tbody tr {
            background-color: #fff;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
            border-radius: 15px;
        }

        .table tbody td {
            padding: 25px 20px !important;
            /* সেলের ভেতর বেশি প্যাডিং */
            color: #444;
            font-size: 15px;
            border: none;
            background: #fff;
        }

        /* Row Hover Effect */
        .table tbody tr:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            z-index: 1;
        }

        .table tbody tr td:first-child {
            border-top-left-radius: 15px;
            border-bottom-left-radius: 15px;
        }

        .table tbody tr td:last-child {
            border-top-right-radius: 15px;
            border-bottom-right-radius: 15px;
        }

        /* Modern Status Badges */
        .status-pill {
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-pill::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .delivered {
            background: #e7f7ef;
            color: #0fa457;
        }

        .delivered::before {
            background: #0fa457;
        }

        .canceled {
            background: #fff0f0;
            color: #d93025;
        }

        .canceled::before {
            background: #d93025;
        }

        .ordered {
            background: #fff8e6;
            color: #f29900;
        }

        .ordered::before {
            background: #f29900;
        }

        /* Action Button */
        .btn-view-order {
            width: 45px;
            height: 45px;
            background: #111;
            color: #fff;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
            text-decoration: none;
        }

        .btn-view-order:hover {
            background: #333;
            color: #fff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Pagination Customization */
        .custom-pagination {
            margin-top: 40px;
        }

        .page-link {
            border: none;
            padding: 12px 18px;
            border-radius: 12px !important;
            color: #111;
            font-weight: 600;
        }

        .active .page-link {
            background: #111 !important;
            color: #fff !important;
        }
    </style>

    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Orders History</h2>
            <div class="row gx-lg-5">
                <div class="col-lg-3">
                    @include('user.account-nav')
                </div>

                <div class="col-lg-9">
                    <div class="order-table-container">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th>Order Details</th>
                                        <th class="text-center">Total Amount</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td class="text-center fw-bold" style="color: #999;">#{{ $order->id }}</td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold text-dark">{{ $order->name }}</span>
                                                    <span class="small text-muted">{{ $order->orderItems->count() }} Items
                                                        Ordered</span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="fw-bold"
                                                    style="font-size: 16px; color: #111;">${{ number_format($order->total, 2) }}</span>
                                            </td>
                                            <td class="text-center">
                                                @if ($order->status == 'delivered')
                                                    <span class="status-pill delivered">Delivered</span>
                                                @elseif ($order->status == 'canceled')
                                                    <span class="status-pill canceled">Canceled</span>
                                                @else
                                                    <span class="status-pill ordered">Processing</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="text-muted small fw-600">{{ $order->created_at->format('d M, Y') }}</span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('user.orders.details', $order->id) }}"
                                                        class="btn-view-order">
                                                        <i class="fa fa-arrow-right"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="custom-pagination d-flex justify-content-center">
                        {{ $orders->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
