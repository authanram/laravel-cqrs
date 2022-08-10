<?php

declare(strict_types=1);

namespace Authanram\LaravelCqrs\Tests\TestFiles;

class CommandHandler
{
    public function __invoke(Command $command): void
    {
        resolve(CqrsStateContract::class)->setState($command->getData());
    }
}
