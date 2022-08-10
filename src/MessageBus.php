<?php

declare(strict_types=1);

namespace Authanram\LaravelCqrs;

use Authanram\LaravelCqrs\Exceptions\MessageNotFoundException;
use Authanram\LaravelCqrs\Exceptions\MessageResolutionException;
use Authanram\LaravelCqrs\Exceptions\HandlerNotFoundException;
use Authanram\LaravelCqrs\Exceptions\InvalidHandlerException;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;
use ReflectionFunction;

abstract class MessageBus implements Contracts\MessageBus
{
    protected array $messages = [];

    public function register(string $message, callable|string $handler): self
    {
        self::authorizeMessage($message);

        self::authorizeHandler($message, $handler);

        $this->messages[$message] = is_callable($handler) ? $handler : new $handler;

        return $this;
    }

    /**
     * @throws MessageResolutionException
     */
    public function send(object $message): mixed
    {
        $handler = $this->messages[$message::class] ?? null;

        if (is_null($handler)) {
            throw new MessageResolutionException(
                sprintf(
                    'Target class [%s] does not exist.',
                    $message::class,
                ),
            );
        }

        return ($handler($message)) ?? null;
    }

    /**
     * @throws MessageNotFoundException
     */
    private static function authorizeMessage(string $message): void
    {
        if (class_exists($message) === false) {
            throw new MessageNotFoundException(
                sprintf(
                    '%s not found: %s',
                    Str::studly(static::type()),
                    $message,
                )
            );
        }
    }

    /**
     * @throws ReflectionException
     * @throws HandlerNotFoundException
     * @throws InvalidHandlerException
     */
    private static function authorizeHandler(string $message, callable|string $handler): void
    {
        $parameters = null;

        if (is_string($handler)) {
            if (class_exists($handler) === false) {
                throw new HandlerNotFoundException(
                    sprintf(
                        'Handler not found: %s',
                        $handler,
                    ),
                );
            }

            $callable = new $handler;

            if (is_callable($callable) === false) {
                throw new InvalidHandlerException(
                    sprintf(
                        'Handler is not invokable: %s',
                        $handler,
                    ),
                );
            }

            $parameters = (new ReflectionClass($callable))
                ->getMethod('__invoke')
                ->getParameters();
        }

        $parameters ??= (new ReflectionFunction($handler))->getParameters();

        if ($parameters === [] || $parameters[0]->getName() !== static::type()) {
            throw new InvalidHandlerException(
                sprintf(
                    'Handler parameter is missing: [%s $%s]',
                    $message,
                    static::type(),
                ),
            );
        }
    }
}
