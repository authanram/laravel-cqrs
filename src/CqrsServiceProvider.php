<?php

declare(strict_types=1);

namespace Authanram\LaravelCqrs;

use Illuminate\Support\ServiceProvider;

final class CqrsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CqrsServiceContract::class, CqrsService::class);
    }
}
