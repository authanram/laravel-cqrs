<?php

declare(strict_types=1);

namespace Authanram\LaravelCqrs\Tests\TestFiles;

use Illuminate\Support\ServiceProvider;

final class LaravelCqrsTestServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CqrsStateContract::class, CqrsState::class);
    }
}
