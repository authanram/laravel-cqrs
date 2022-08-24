<?php

declare(strict_types=1);

namespace Authanram\LaravelCqrs\Contracts;

use Authanram\LaravelCqrs\Exceptions\ClassNotFoundException;
use Authanram\LaravelCqrs\Exceptions\HandlerNotFoundException;
use Authanram\LaravelCqrs\Exceptions\InvalidHandlerException;
use ReflectionException;

interface MessageBus
{
    /**
     * @param class-string<mixed> $message
     * @param callable|class-string<callable> $handler
     *
     * @return self
     *
     * @throws ClassNotFoundException
     * @throws HandlerNotFoundException
     * @throws InvalidHandlerException
     * @throws ReflectionException
     */
    public function register(string $message, callable|string $handler): self;
}
