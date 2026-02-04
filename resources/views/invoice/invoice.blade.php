<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 13px;
            color: #444;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .invoice-wrapper {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 50px; /* পর্যাপ্ত প্যাডিং দেওয়া হয়েছে যাতে ডান পাশে লেগে না থাকে */
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        /* প্রফেশনাল হেডার ডিজাইন */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #1a237e;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .company-info h1 {
            margin: 0;
            color: #1a237e;
            font-size: 26px;
            text-transform: uppercase;
        }
        .company-info p {
            margin: 2px 0;
            font-size: 12px;
            color: #666;
        }
        .invoice-meta {
            text-align: right;
        }
        .invoice-meta h2 {
            margin: 0;
            color: #1a237e;
            font-size: 32px;
            letter-spacing: 2px;
        }

        /* বিলিং সেকশন */
        .billing-grid {
            width: 100%;
            margin-bottom: 40px;
        }
        .billing-title {
            font-size: 11px;
            text-transform: uppercase;
            font-weight: bold;
            color: #1a237e;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
            padding-bottom: 5px;
        }
        .billing-content {
            font-size: 13px;
        }

        /* মডার্ন টেবিল স্টাইল */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table thead th {
            background-color: #f8f9fa;
            color: #1a237e;
            padding: 15px 10px;
            text-align: left;
            border-bottom: 2px solid #1a237e;
            font-weight: bold;
            font-size: 12px;
        }
        .items-table tbody td {
            padding: 15px 10px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }
        .product-img {
            border-radius: 4px;
            object-fit: cover;
            border: 1px solid #eee;
        }

        /* টোটাল ক্যালকুলেশন এরিয়া */
        .summary-wrapper {
            width: 100%;
            margin-top: 20px;
        }
        .notes-box {
            width: 50%;
            float: left;
            background: #fdfdfd;
            padding: 15px;
            border-left: 3px solid #1a237e;
            font-size: 11px;
        }
        .totals-box {
            width: 40%;
            float: right;
        }
        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 8px 5px;
            text-align: right;
        }
        .totals-table .label {
            color: #666;
            text-align: left;
        }
        .grand-total-row td {
            padding-top: 15px;
            border-top: 2px solid #1a237e;
            font-size: 18px;
            font-weight: bold;
            color: #1a237e;
        }

        .clear { clear: both; }

        /* ফুটার */
        .footer {
            margin-top: 50px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #999;
            font-size: 11px;
        }

        /* স্ট্যাটাস ব্যাজ */
        .status-paid { color: #2e7d32; font-weight: bold; }
        .status-pending { color: #ef6c00; font-weight: bold; }
    </style>
</head>
<body>

<div class="invoice-wrapper">
    <table class="header-table">
        <tr>
            <td class="company-info">
                <h1>CodeNest Agency</h1>
                <p>Premier Web & Software Solutions</p>
                <p>Uttara, Dhaka, Bangladesh</p>
                <p>support@codenest.com | +880 1XXXXXXXXX</p>
            </td>
            <td class="invoice-meta">
                <h2>INVOICE</h2>
                <p style="margin:0;"><strong>#{{ $order->id }}</strong></p>
                <p style="margin:0; color:#666;">Date: {{ $order->created_at->format('d M, Y') }}</p>
            </td>
        </tr>
    </table>

    <table class="billing-grid">
        <tr>
            <td width="50%" style="vertical-align: top; padding-right: 20px;">
                <div class="billing-title">Client Information</div>
                <div class="billing-content">
                    <strong style="font-size: 15px; color:#333;">{{ $order->name }}</strong><br>
                    {{ $order->address }}<br>
                    {{ $order->city }} - {{ $order->zip }}<br>
                    Phone: {{ $order->phone }}
                </div>
            </td>
            <td width="50%" style="vertical-align: top; padding-left: 20px;">
                <div class="billing-title">Payment Details</div>
                <div class="billing-content">
                    <strong>Method:</strong> {{ strtoupper($order->transaction->mode ?? 'Cash') }}<br>
                    <strong>Status:</strong>
                    @php
                        $status = $order->transaction->status ?? 'pending';
                    @endphp
                    <span class="{{ $status == 'approved' ? 'status-paid' : 'status-pending' }}">
                        {{ strtoupper($status) }}
                    </span>
                </div>
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th width="10%">Image</th>
                <th width="45%">Description</th>
                <th width="10%" style="text-align: center;">Qty</th>
                <th width="15%" style="text-align: right;">Unit Price</th>
                <th width="20%" style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
            <tr>
                <td>
                    <img src="{{ public_path('uploads/products/' . $item->product->image) }}" width="45" height="45" class="product-img">
                </td>
                <td>
                    <div style="font-weight: bold; color: #333;">{{ $item->product->name }}</div>
                    <small style="color:#888;">SKU: {{ $item->product->sku ?? 'N/A' }}</small>
                </td>
                <td style="text-align: center;">{{ $item->quantity }}</td>
                <td style="text-align: right;">৳{{ number_format($item->price, 2) }}</td>
                <td style="text-align: right; font-weight: bold; color: #1a237e;">৳{{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-wrapper">
        <div class="notes-box">
            <div style="font-weight: bold; margin-bottom: 5px; color: #1a237e;">TERMS & CONDITIONS</div>
            <p style="margin: 0;">1. Items once sold are not returnable unless defective.</p>
            <p style="margin: 0;">2. Warranty claims require the original invoice.</p>
            <p style="margin: 0;">3. This is an electronically generated document.</p>
        </div>

        <div class="totals-box">
            <table class="totals-table">
                <tr>
                    <td class="label">Subtotal</td>
                    <td>৳{{ number_format($order->subtotal, 2) }}</td>
                </tr>
                @if($order->tax > 0)
                <tr>
                    <td class="label">VAT (Tax)</td>
                    <td>৳{{ number_format($order->tax, 2) }}</td>
                </tr>
                @endif
                @if($order->discount > 0)
                <tr>
                    <td class="label" style="color: #c62828;">Discount (-)</td>
                    <td style="color: #c62828;">৳{{ number_format($order->discount, 2) }}</td>
                </tr>
                @endif
                <tr class="grand-total-row">
                    <td class="label">Net Payable</td>
                    <td>৳{{ number_format($order->total, 2) }}</td>
                </tr>
            </table>
        </div>
        <div class="clear"></div>
    </div>

    <div class="footer">
        <p>Thank you for your business! If you have any questions, feel free to contact us.</p>
        <strong>www.codenest.com</strong>
    </div>
</div>

</body>
</html>
