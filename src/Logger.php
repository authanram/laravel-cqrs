<?php

declare(strict_types=1);

namespace Authanram\LaravelCqrs;

use Illuminate\Support\Facades\Log;

/**
 * @method static void alert(string $message, array $context = [])
 * @method static void critical(string $message, array $context = [])
 * @method static void debug(string $message, array $context = [])
 * @method static void emergency(string $message, array $context = [])
 * @method static void error(string $message, array $context = [])
 * @method static void info(string $message, array $context = [])
 * @method static void notice(string $message, array $context = [])
 * @method static void warning(string $message, array $context = [])
 */
final class Logger implements Contracts\Logger
{
    public function command(): self
    {
        self::setup(config('laravel-cqrs.logging.command'));

        return $this;
    }

    public function query(): self
    {
        self::setup(config('laravel-cqrs.logging.query'));

        return $this;
    }

    public function __call(string $name, array $arguments)
    {
        Log::{$name}($arguments[0], $arguments[1] ?? []);
    }

    private static function setup(array $config): void
    {
        Log::stack(
            channels: $config['stack'],
            channel: $config['channel'],
        );
    }
}
