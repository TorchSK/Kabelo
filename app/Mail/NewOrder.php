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
        return $this->from('kabelo@kabelo.sk')->subject('Objednávka')->view('emails.neworder');
    }
}
