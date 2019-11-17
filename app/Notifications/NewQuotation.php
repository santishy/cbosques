<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\Http\Resources\QuoteResource;
use App\Mail\BudgetCreated;

class NewQuotation extends Notification 
{
    use Queueable;
    public $quotation;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($quotation)
    {
        $this->quotation = $quotation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // return (new MailMessage)
        //             ->line('The introduction to the notification.')
        //             ->action('Notification Action', url('/'))
        //             ->line('Thank you for using our application!');
        return (new BudgetCreated($this->quotation,$notifiable))->to($notifiable->email)
                ->subject('Nueva Cotización');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
                'link' => 'quotations-show',
                'text' => 'Ha creado una cotización el usuario '. $this->quotation->user->name,
                'data' => new QuoteResource($this->quotation),
                'notifiable' => $notifiable
               ];
    }
}
