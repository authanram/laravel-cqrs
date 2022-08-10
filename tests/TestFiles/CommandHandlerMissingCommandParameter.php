<?php

declare(strict_types=1);

namespace Authanram\LaravelCqrs\Tests\TestFiles;

class CommandHandlerMissingCommandParameter
{
    public function __invoke(): void
    {
    }
}
