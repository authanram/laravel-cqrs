<?php

declare(strict_types=1);

namespace Authanram\LaravelCqrs\Contracts;

interface QueryBus extends MessageBus
{
    public function send(object $message): mixed;
}
