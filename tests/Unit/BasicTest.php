<?php

declare(strict_types=1);

use Authanram\LaravelCqrs\Contracts\CommandBus;
use Authanram\LaravelCqrs\Contracts\QueryBus;

test('command-bus can be resolved', function (): void {
    expect(resolve(CommandBus::class))->toBeInstanceOf(CommandBus::class);
});

test('query-bus can be resolved', function (): void {
    expect(resolve(QueryBus::class))->toBeInstanceOf(QueryBus::class);
});
