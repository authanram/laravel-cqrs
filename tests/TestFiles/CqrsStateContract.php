<?php

declare(strict_types=1);

namespace Authanram\LaravelCqrs\Tests\TestFiles;

interface CqrsStateContract
{
    public function getState(): mixed;

    public function setState(mixed $state): CqrsState;
}
