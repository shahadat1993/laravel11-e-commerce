<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f6f6f6; padding:20px;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="600" style="background:#ffffff; padding:25px; border-radius:6px;">

```
                <tr>
                    <td align="center">
                        <h2 style="color:#333;">Thank you for your order 🎉</h2>
                        <p style="color:#555;">
                            Hi <strong>{{ $order->name }}</strong>,<br>
                            We have received your order successfully. Below are the details of your purchase.
                        </p>
                    </td>
                </tr>

                <tr><td><hr></td></tr>

                <tr>
                    <td>
                        <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                        <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
                        <p><strong>Total Amount:</strong> ৳{{ number_format($order->total, 2) }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($order->status ?? 'Pending') }}</p>
                    </td>
                </tr>

                <tr><td><hr></td></tr>

                <tr>
                    <td>
                        <h3 style="color:#333;">Ordered Items</h3>

                        @foreach ($order->orderItems as $item)
                            <table width="100%" style="margin-bottom:15px;">
                                <tr>
                                    <td width="80">
                                       <img src="{{ url('uploads/products/'.$item->product->image) }}" width="70" style="border-radius:6px;">


                                    </td>
                                    <td>
                                        <p style="margin:0;">
                                            <strong>{{ $item->product->name }}</strong><br>
                                            Quantity: {{ $item->quantity }} <br>
                                            Price: ৳{{ number_format($item->price, 2) }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        @endforeach

                    </td>
                </tr>

                <tr><td><hr></td></tr>

                <tr>
                    <td>
                        <h3>Shipping Address</h3>
                        <p>
                            {{ $order->address }}, {{ $order->locality }}<br>
                            {{ $order->city }}, {{ $order->state }} - {{ $order->zip }}
                        </p>
                    </td>
                </tr>

                <tr><td><hr></td></tr>

                <tr>
                    <td align="center">
                        <a href="{{ route('invoice.download', $order->id) }}"
                           style="background:#28a745; color:#fff; padding:12px 20px;
                           text-decoration:none; border-radius:4px; display:inline-block;">
                            Download Invoice (PDF)
                        </a>
                    </td>
                </tr>

                <tr>
                    <td align="center" style="padding-top:20px; color:#777;">
                        <p>
                            We will notify you once your order is shipped or delivered.<br>
                            If you have any questions, feel free to contact us.
                        </p>
                        <p style="margin-top:10px;">
                            — <strong>CodeNest Agency</strong>
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
```

</body>
</html>

valo kore dekho image ta astese na kn
