<?php

declare(strict_types=1);

namespace Authanram\LaravelCqrs;

final class QueryBus extends MessageBus implements Contracts\QueryBus
{
    public static function type(): string
    {
        return 'query';
    }
}
