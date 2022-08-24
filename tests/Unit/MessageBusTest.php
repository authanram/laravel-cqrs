<?php /** @noinspection PhpUnhandledExceptionInspection, StaticClosureCanBeUsedInspection */

declare(strict_types=1);

use Authanram\LaravelCqrs\Contracts\CommandBus;
use Authanram\LaravelCqrs\Exceptions;
use Authanram\LaravelCqrs\Tests\TestFiles\Command;
use Authanram\LaravelCqrs\Tests\TestFiles\CommandHandlerNotInvokable;
use Authanram\LaravelCqrs\Tests\TestFiles\UnregisteredCommand;

beforeEach(function () {
    $this->service = resolve(CommandBus::class);
});

it('throws if message class does not exist', function (): void {
    $this->service->register('foo', 'bar');
})->expectException(Exceptions\ClassNotFoundException::class);

it('throws if message handler class does not exist', function (): void {
    $this->service->register(Command::class, 'bar');
})->expectException(Exceptions\HandlerNotFoundException::class);

it('throws if the message handler [invokable] is not invokable', function (): void {
    $this->service->register(Command::class, CommandHandlerNotInvokable::class);
})->expectExceptionMessage('Handler is not invokable: '.CommandHandlerNotInvokable::class);

it('throws while handling unregistered command', function (): void {
    $this->service->send(new UnregisteredCommand());
})->expectExceptionMessage('Target class ['.UnregisteredCommand::class.'] does not exist.');
