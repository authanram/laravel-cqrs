<?php

declare(strict_types=1);

namespace Authanram\LaravelCqrs\Tests\TestFiles;

class Query
{
    public function getData(): string
    {
        return __CLASS__;
    }
}
