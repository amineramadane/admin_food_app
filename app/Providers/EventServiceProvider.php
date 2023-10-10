<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Elmas\Listeners\SendEmailVerificationNotification;
use App\Models\MvStock;
use App\Models\Nomenclature;
use App\Models\Commande;
use App\Models\SuiviFabrication;
use App\Models\OrdreFabrication;
use App\Models\PosteCharge;
use App\Observers\MvStockObserve;
use App\Observers\NomenclatureObserve;
use App\Observers\CommandeObserver;
use App\Observers\SuiviFabricationObserve;
use App\Observers\OrdreFabricationObserve;
use App\Observers\PosteChargeObserve;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        
        'Illuminate\Auth\Events\Login' => [
            'App\Elmas\Listeners\AuditLogin',
        ],

        'Illuminate\Auth\Events\Logout' => [
            'App\Elmas\Listeners\AuditLogout',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
