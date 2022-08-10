<?php

declare(strict_types=1);

namespace Authanram\LaravelCqrs;

final class CommandBus extends MessageBus implements Contracts\CommandBus
{
    public static function type(): string
    {
        return 'command';
    }
}
