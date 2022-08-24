<?php

declare(strict_types=1);

use Authanram\LaravelCqrs\Contracts\Logger;
use Illuminate\Support\Facades\Log;

beforeEach(function () {
    $this->log = resolve(Logger::class);
});

$levels = [
    'alert',
    'critical',
    'debug',
    'emergency',
    'error',
    'info',
    'notice',
    'warning',
];

foreach (['command', 'query'] as $type) {
    foreach ($levels as $level) {
        it("logs $type:$level", function () use ($level, $type): void {
            $config = config("laravel-cqrs.logging.$type");

            Log::shouldReceive('stack')
                ->with($config['stack'], $config['channel']);

            Log::shouldReceive($level)
                ->with("$type:$level", [])
                ->once();

            $this->log->{$type}()
                ->{$level}("$type:$level");
        });
    }
}
