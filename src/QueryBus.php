<?php

declare(strict_types=1);

namespace Authanram\LaravelCqrs;

final class QueryBus extends MessageBus implements Contracts\QueryBus
{
    /**
     * @throws Exceptions\MessageResolutionException
     */
    public function send(object $message): mixed
    {
        return $this->handle($message);
    }
}
