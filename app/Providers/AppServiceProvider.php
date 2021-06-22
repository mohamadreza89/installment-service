<?php

namespace App\Providers;

use App\Contracts\InstallmentServiceInterface;
use App\Contracts\OrderItemRepositoryInterface;
use App\Repositories\OrderItemRepository;
use App\Services\InstallmentService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $this->app->singleton(InstallmentServiceInterface::class, InstallmentService::class);
        $this->app->singleton(OrderItemRepositoryInterface::class, OrderItemRepository::class);
    }
}
