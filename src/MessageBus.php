<?php

declare(strict_types=1);

namespace Authanram\LaravelCqrs;

use Authanram\LaravelCqrs\Contracts\Logger;
use Authanram\LaravelCqrs\Exceptions\ClassNotFoundException;
use Authanram\LaravelCqrs\Exceptions\HandlerNotFoundException;
use Authanram\LaravelCqrs\Exceptions\InvalidHandlerException;
use Authanram\LaravelCqrs\Exceptions\MessageResolutionException;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;
use ReflectionFunction;

abstract class MessageBus implements Contracts\MessageBus
{
    protected array $messages = [];

    private static function type(): string
    {
        return Str::of(class_basename(static::class))
            ->beforeLast('Bus')
            ->kebab()
            ->toString();
    }

    public function __construct(private Logger $logger)
    {
    }

    public function register(string $message, callable|string $handler): self
    {
        self::authorizeMessage($message);

        self::authorizeHandler($message, $handler);

        $this->messages[$message] = $handler;

        return $this;
    }

    /**
     * @throws MessageResolutionException
     */
    protected function handle(object $message): mixed
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

        if (is_callable($handler) === false) {
            $handler = new $handler;
        }

        return ($handler($message)) ?? null;
    }

    /**
     * @throws ClassNotFoundException
     */
    private static function authorizeMessage(string $message): void
    {
        if (class_exists($message) === false) {
            throw new ClassNotFoundException(
                sprintf(
                    '%s not found: %s',
                    Str::studly(self::type()),
                    $message,
                )
            );
        }
    }

    /**
     * @throws InvalidHandlerException
     * @throws HandlerNotFoundException
     * @throws ReflectionException
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
