<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function download(Order $order)
    {
        // Ensure order items and product relationship is loaded
        $order->load('orderItems.product');

        // Load invoice view
        $pdf = Pdf::loadView('invoice.invoice', compact('order'));

        // Download PDF
        return $pdf->download('invoice-order-'.$order->id.'.pdf');
    }
}
