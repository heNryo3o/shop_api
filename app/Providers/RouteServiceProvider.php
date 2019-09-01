<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {

        $this->mapAdminRoutes();

        $this->mapSellerRoutes();

    }

    protected function mapAdminRoutes()
    {
        Route::prefix('admin')
            ->middleware('auth:admin')
            ->namespace('App\Http\Controllers\Admin')
            ->group(base_path('routes/admin.php'));
    }

    protected function mapSellerRoutes()
    {
        Route::prefix('seller')
            ->middleware('auth:seller')
            ->namespace('App\Http\Controllers\Seller')
            ->group(base_path('routes/seller.php'));
    }

}
