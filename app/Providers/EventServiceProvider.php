<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
     protected $listen = [
         'App\Events\CycleInsert' => [
             'App\Listeners\DeactiveCycles',
         ],
         'App\Events\ItemInsert' => [
           'App\Listeners\subtractItemFromBudget'
         ],
         'App\Events\QuotationCreated' => [
           'App\Listeners\NotifyUsersAboutNewQuotation',
           'App\Listeners\AdjustItemQty',
         ],
         'App\Events\UpdatedQuotation'=>[
           'App\Listeners\NotifyUserAboutUpdatedQuotation',
           'App\Listeners\BudgetDecrease'
         ],
         'App\Events\UpdatedItem' => [
           'App\Listeners\AdjustBudgetQty'
         ]
     ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
