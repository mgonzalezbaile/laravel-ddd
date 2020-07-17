<?php

namespace App\Infrastructure\Provider;

use App\Domain\Model\Resource;
use App\Domain\Model\ResourceRepository;
use App\Infrastructure\Output\Persistence\DoctrineResourceRepository;
use Ddd\FakeUuidGenerator;
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
        $this->app->bind(ResourceRepository::class, fn($app) => new DoctrineResourceRepository($app['em'], $app['em']->getClassMetaData(Resource::class)));
        $this->app->bind(FakeUuidGenerator::class, fn($app) => FakeUuidGenerator::withUuid(FakeUuidGenerator::DEFAULT));
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
