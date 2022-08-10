<?php

declare(strict_types=1);

namespace Authanram\LaravelCqrs\Tests\TestFiles;

class CqrsState
{
    private mixed $state = null;

    public function getState(): mixed
    {
        return $this->state;
    }

    public function setState(mixed $state): CqrsState
    {
        $this->state = $state;

        return $this;
    }
}
