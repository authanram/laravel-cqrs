<?php

declare(strict_types=1);

namespace Authanram\LaravelCqrs\Tests;

use Authanram\LaravelCqrs\LaravelCqrsServiceProvider;
use Authanram\LaravelCqrs\Tests\TestFiles\LaravelCqrsTestServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            LaravelCqrsServiceProvider::class,
            LaravelCqrsTestServiceProvider::class,
        ];
    }
}
