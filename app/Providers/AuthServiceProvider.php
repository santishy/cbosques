<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Department;
use App\Policies\DepartmentPolicy;
use App\Quotation;
use App\Policies\NotificationPolicy;
use App\Policies\QuotationPolicy;
use Illuminate\Notifications\DatabaseNotification;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\User' => 'App\Policies\UserPolicy',
        Department::class =>DepartmentPolicy::class,
        //Notification::class => NotificationPolicy::class,
        QuotationPolicy::class => QuotationPolicy::class,
        DatabaseNotification::class => NotificationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
