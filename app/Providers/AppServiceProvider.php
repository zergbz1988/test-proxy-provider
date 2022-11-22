<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Proxy\Domain\Provider;
use Proxy\Infrastructure\Provider\AbstractProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        Provider::class => AbstractProvider::class
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
