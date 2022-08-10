<?php

declare(strict_types=1);

namespace Authanram\LaravelCqrs;

use Error;
use Illuminate\Support\Facades\Log;
use TypeError;

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
final class Logger
{
    /**
     * @throws Error
     */
    public static function __callStatic(string $function, array $arguments)
    {
        if (in_array($function, self::levels(), true) === false) {
            throw new Error(
                sprintf(
                    'Call to undefined method %s',
                    self::class.'::'.$function.'()',
                ),
            );
        }

        if (isset($arguments[0]) === false) {
            throw new TypeError(
                sprintf(
                    'Too few arguments to function %s, %s passed.',
                    self::class.'::'.$function.'()',
                    count($arguments),
                ),
            );
        }

        self::log($arguments[0], $arguments[1] ?? [], $function);
    }

    private static function log(string $message, array $context = [], string $level = 'info'): void
    {
        $config = config('laravel-cqrs.logging');

        $config['stack'][] = Log::build($config['channel']);

        Log::stack($config['stack'])->{$level}($message, $context);
    }

    private static function levels(): array
    {
        return [
            'alert',
            'critical',
            'debug',
            'emergency',
            'error',
            'info',
            'notice',
            'warning',
        ];
    }
}
