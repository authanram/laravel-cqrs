<?php

declare(strict_types=1);

namespace Authanram\LaravelCqrs\Tests\TestFiles;

class QueryHandler
{
    public function __invoke(Query $query): string
    {
        return $query->getData();
    }
}
