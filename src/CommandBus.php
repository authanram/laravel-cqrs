<?php

declare(strict_types=1);

namespace Authanram\LaravelCqrs;

final class CommandBus extends MessageBus implements Contracts\CommandBus
{
    /**
     * @throws Exceptions\MessageResolutionException
     */
    public function send(object $message): void
    {
        $this->handle($message);
    }
}
