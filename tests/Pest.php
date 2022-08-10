<?php

declare(strict_types=1);

use Authanram\LaravelCqrs\CqrsServiceContract;
use Authanram\LaravelCqrs\Tests\TestCase;

uses(TestCase::class)->in('Unit');

function service(): CqrsServiceContract
{
    return resolve(CqrsServiceContract::class);
}
