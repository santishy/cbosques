<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BudgetCreated extends Mailable 
{
    use Queueable, SerializesModels;
    public $quotation;
    public $notifiable;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($quotation,$notifiable)
    {
        $this->quotation = $quotation;
        $this->notifiable = $notifiable;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.quotations.created',
                    ['url'=>url('/quotations/show/'),
                    "quotation" => $this->quotation])
                    ->attachFromStorage($this->quotation->archive)
                    ->subject('Nueva Cotización');
    }
}
