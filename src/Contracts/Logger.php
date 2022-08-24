<?php

declare(strict_types=1);

namespace Authanram\LaravelCqrs\Contracts;

interface Logger
{
    public function command(): self;

    public function query(): self;
}
