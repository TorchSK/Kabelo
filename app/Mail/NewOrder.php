<?php

namespace App\Mail;

use App\Order;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $products;
    public $images;
    public $delivery_method;
    public $payment_method;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
         $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->products = Order::where('id', $this->order['id'])->first()->products;
        $this->images = Order::where('id', $this->order['id'])->first()->products->pluck('image');

        $this->delivery_method = Order::where('id', $this->order['id'])->first()->delivery;
        $this->payment_method = Order::where('id', $this->order['id'])->first()->payment;

        return $this->from('kabelo@kabelo.sk')
                     ->subject('Objednávka č. '.$this->order['id'])
                     ->view('emails.neworder')
                     ->attach(storage_path('app/OBCHODNÉ_PODMIENKY.pdf'))
                     ->attach(storage_path('app/Vzorový formulár na odstúpenie od zmluvy.docs'));

    }
}
