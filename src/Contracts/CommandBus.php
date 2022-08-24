<?php

declare(strict_types=1);

namespace Authanram\LaravelCqrs\Contracts;

interface CommandBus extends MessageBus
{
    public function send(object $message): void;
}
