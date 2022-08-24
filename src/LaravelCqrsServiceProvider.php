<?php

declare(strict_types=1);

namespace Authanram\LaravelCqrs;

use Illuminate\Support\ServiceProvider;

final class LaravelCqrsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(Contracts\Logger::class, Logger::class);

        $this->app->singleton(Contracts\CommandBus::class, CommandBus::class);

        $this->app->singleton(Contracts\QueryBus::class, QueryBus::class);
    }

    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-cqrs.php', 'laravel-cqrs');
    }
}
