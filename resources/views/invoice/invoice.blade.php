<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->id }}</title>

    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }

        .container {
            width: 100%;
            padding: 25px;
        }

        .header {
            width: 100%;
            margin-bottom: 30px;
        }

        .company {
            width: 50%;
            float: left;
        }

        .company h2 {
            margin: 0;
            color: #2c7be5;
        }

        .invoice-info {
            width: 50%;
            float: right;
            text-align: right;
        }

        .clear {
            clear: both;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            font-weight: bold;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background: #f2f4f6;
            border: 1px solid #ddd;
            padding: 8px;
            font-weight: bold;
        }

        table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .totals {
            width: 40%;
            float: right;
        }

        .totals td {
            border: none;
            padding: 5px 0;
        }

        .totals tr:last-child td {
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 8px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 11px;
            color: #777;
        }

        img {
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="container">

        <!-- HEADER -->
        <div class="header">
            <div class="company">
                <h2>CodeNest Agency</h2>
                <p>
                    Web & Software Solutions<br>
                    Dhaka, Bangladesh<br>
                    support@codenest.com
                </p>
            </div>

            <div class="invoice-info">
                <h3>INVOICE</h3>
                <p>
                    Invoice #: {{ $order->id }}<br>
                    Date: {{ $order->created_at->format('d M Y') }}<br>
                    Status: {{ strtoupper($order->status) }}
                </p>
            </div>
            <div class="clear"></div>
        </div>

        <!-- BILLING -->
        <div class="section">
            <div class="section-title">Billing Information</div>
            <table>
                <tr>
                    <td>
                        <strong>{{ $order->name }}</strong><br>
                        {{ $order->address }}<br>
                        {{ $order->locality }}, {{ $order->city }}<br>
                        {{ $order->state }} - {{ $order->zip }}<br>
                        Phone: {{ $order->phone }}
                    </td>
                    <td>
    <strong>Payment Method:</strong><br>
    {{ strtoupper($order->transaction->mode ?? 'Cash On Delivery') }}<br><br>

    <strong>Transaction Status:</strong><br>
    @php
        $status = $order->transaction->status ?? 'pending';
        $color = '';
        if ($status == 'approved') {
            $color = 'green';
        } elseif ($status == 'refunded' || $status == 'declined' || $status == 'canceled') {
            $color = 'red';
        } else {
            $color = 'orange';
        }
    @endphp
    <span style="color: {{ $color }}; font-weight: bold;">{{ ucfirst($status) }}</span>
</td>


                </tr>
            </table>
        </div>

        <!-- ITEMS -->
        <div class="section">
            <div class="section-title">Order Items</div>

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th class="text-center">Image</th>
                        <th class="text-center">Qty</th>
                        <th class="text-right">Price</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($order->orderItems as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td class="text-center">
                                <img src="{{ public_path('uploads/products/' . $item->product->image) }}" width="45">
                            </td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-right">৳{{ number_format($item->price, 2) }}</td>
                            <td class="text-right">
                                ৳{{ number_format($item->price * $item->quantity, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- TOTALS -->
        <div class="section">
            <table class="totals">
                <tr>
                    <td>Subtotal:</td>
                    <td class="text-right">৳{{ number_format($order->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td>Discount:</td>
                    <td class="text-right">৳{{ number_format($order->discount, 2) }}</td>
                </tr>
                <tr>
                    <td>Tax:</td>
                    <td class="text-right">৳{{ number_format($order->tax, 2) }}</td>
                </tr>
                <tr>
                    <td>Total Payable:</td>
                    <td class="text-right">৳{{ number_format($order->total, 2) }}</td>
                </tr>
            </table>
            <div class="clear"></div>
        </div>

        <!-- FOOTER -->
        <div class="footer">
            <p>
                This is a system-generated invoice. No signature required.<br>
                Thank you for shopping with <strong>CodeNest Agency</strong>.
            </p>
        </div>

    </div>
</body>

</html>
