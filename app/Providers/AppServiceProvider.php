<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
	    view()->composer(
		    ['layouts.admin','orders.all', 'orders.canceled','orders.delivered','orders.pending','admin.products'],
		    'App\Http\ViewComposers\AdminComposer'
	    );
    }
}
