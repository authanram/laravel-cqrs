<?php

declare(strict_types=1);

namespace Authanram\LaravelCqrs\Tests;

use Authanram\LaravelCqrs\CqrsServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            CqrsServiceProvider::class,
        ];
    }
}
