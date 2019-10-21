<?php

namespace App\Listeners;

use App\Events\QuotationCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewQuotation;
use Illuminate\Database\Eloquent\Builder;

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
        $users = Auth::user()->whereHas('roles',function(Builder $query){
          $query->where('name','admin')->orWhere('name','autorizador');
        })->get();
        Notification::send($users,new NewQuotation($event->quotation));
    }
}
