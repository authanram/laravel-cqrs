<?php /** @noinspection PhpUnhandledExceptionInspection, StaticClosureCanBeUsedInspection */

declare(strict_types=1);

use Authanram\LaravelCqrs\Contracts\QueryBus;
use Authanram\LaravelCqrs\Tests\TestFiles\Query;
use Authanram\LaravelCqrs\Tests\TestFiles\QueryHandler;
use Authanram\LaravelCqrs\Tests\TestFiles\QueryHandlerMissingQueryParameter;
use Authanram\LaravelCqrs\Tests\TestFiles\QueryOther;

beforeEach(function () {
    $this->messageBus = resolve(QueryBus::class);
});

it('throws if the handler [closure] is not invokable', function (): void {
    $this->messageBus->register(Query::class, fn () => null);
})->expectExceptionMessage('Handler parameter is missing: ['.Query::class.' $query]');

it('throws if the handler parameter [$command] is missing', function (): void {
    $this->messageBus->register(Query::class, QueryHandlerMissingQueryParameter::class);
})->expectExceptionMessage('Handler parameter is missing: ['.Query::class.' $query]');

it('registers messages', function (): void {
    $messageHandler = fn (Query $query) => null;

    $this->messageBus
        ->register(Query::class, QueryHandler::class)
        ->register(QueryOther::class, $messageHandler);

    $messagesProperty = (new ReflectionObject($this->messageBus))
        ->getProperty('messages');

    $messagesProperty->setAccessible(true);

    expect($messagesProperty->getValue($this->messageBus))
        ->toEqual([
            Query::class => new QueryHandler(),
            QueryOther::class => $messageHandler,
        ]);
});

it('handles queries', function () {
    $result = $this->messageBus
        ->register(Query::class, QueryHandler::class)
        ->send(new Query());

    expect($result)->toEqual(Query::class);
});
