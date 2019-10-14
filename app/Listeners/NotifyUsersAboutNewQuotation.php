<?php

namespace App\Listeners;

use App\Events\QuotationCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewQuotation;


class NotifyUsersAboutNewQuotation
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  QuotationCreated  $event
     * @return void
     */
    public function handle(QuotationCreated $event)
    {
        $user = Auth::user();
        Notification::send($user,new NewQuotation($event->quotation));
    }
}
