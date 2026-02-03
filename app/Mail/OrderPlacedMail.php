<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Queue\SerializesModels;

class OrderPlacedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        // PDF generate
        $pdf = Pdf::loadView('invoice.invoice', ['order' => $this->order]);

        return $this->subject('Your Order Confirmation')
            ->view('emails.order-placed')
            ->attachData($pdf->output(), 'invoice-' . $this->order->id . '.pdf');
    }
}
