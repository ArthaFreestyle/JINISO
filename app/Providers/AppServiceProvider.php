<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(\App\Repositories\Contracts\CategoryRepositoryInterface::class, \App\Repositories\CategoryRepository::class);

        $this->app->singleton(\App\Repositories\Contracts\OrderRepositoryInterface::class, \App\Repositories\OrderRepository::class);

        $this->app->singleton(\App\Repositories\Contracts\ProductsRepositoryInterface::class, \App\Repositories\ProductsRepository::class);
        
        $this->app->singleton(\App\Repositories\Contracts\PromoCodeRepositoryInterface::class, \App\Repositories\PromoCodeRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
    }
}
