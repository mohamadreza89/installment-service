<?php


namespace App\Services;


use App\Contracts\InstallmentServiceInterface;
use App\Models\Installment;
use App\Models\InstallmentDetail;
use App\Services\Contracts\InstallmentCreatorInterface;
use App\Services\Contracts\InstallmentDetailCreatorInterface;
use App\Services\Lib\InstallmentCreator;
use App\Services\Lib\InstallmentDetailCreator;
use Illuminate\Support\ServiceProvider;

class LibServiceProvider extends ServiceProvider
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
        $this->app->singleton(InstallmentDetailCreatorInterface::class, function (){
            return new InstallmentDetailCreator(InstallmentDetail::query());
        });
        $this->app->singleton(InstallmentCreatorInterface::class, function (){
            return new InstallmentCreator(Installment::query());
        });
    }

}
