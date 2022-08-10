<?php

declare(strict_types=1);

namespace Authanram\LaravelCqrs\Contracts;

use Authanram\LaravelCqrs\Exceptions\MessageNotFoundException;
use Authanram\LaravelCqrs\Exceptions\HandlerNotFoundException;
use Authanram\LaravelCqrs\Exceptions\InvalidHandlerException;
use ReflectionException;

interface MessageBus
{
    public static function type(): string;

    /**
     * @param class-string<mixed> $message
     * @param callable|class-string<callable> $handler
     *
     * @return self
     *
     * @throws InvalidHandlerException
     * @throws HandlerNotFoundException
     * @throws MessageNotFoundException
     * @throws ReflectionException
     */
    public function register(string $message, callable|string $handler): self;

    /**
     * @param object $message
     *
     * @return self
     */
    public function send(object $message): mixed;
}
