<?php

namespace App\Infrastructure\Provider;

use Ddd\RamseyUuidGenerator;
use Ddd\UuidGenerator;
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
        $this->app->bind(UuidGenerator::class, RamseyUuidGenerator::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
