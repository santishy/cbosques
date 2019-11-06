<?php

namespace App\Listeners;

use App\Events\UpdatedQuotation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\QuoteResponse;

class NotifyUserAboutUpdatedQuotation
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
     * @param  QuotationUpdated  $event
     * @return void
     */
    public function handle(UpdatedQuotation $event)
    {
      $user = $event->quotation->user;
      Notification::send($user,new QuoteResponse($event->quotation));
    }
}
