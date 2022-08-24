<?php /** @noinspection PhpUnhandledExceptionInspection, StaticClosureCanBeUsedInspection */

declare(strict_types=1);

use Authanram\LaravelCqrs\Contracts\CommandBus;
use Authanram\LaravelCqrs\Tests\TestFiles\Command;
use Authanram\LaravelCqrs\Tests\TestFiles\CommandHandler;
use Authanram\LaravelCqrs\Tests\TestFiles\CommandHandlerMissingCommandParameter;
use Authanram\LaravelCqrs\Tests\TestFiles\CommandOther;
use Authanram\LaravelCqrs\Tests\TestFiles\CqrsStateContract;

beforeEach(function () {
    $this->messageBus = resolve(CommandBus::class);
});

it('throws if the handler [closure] is not invokable', function (): void {
    $this->messageBus->register(Command::class, fn () => null);
})->expectExceptionMessage('Handler parameter is missing: ['.Command::class.' $command]');

it('throws if the handler parameter [$command] is missing', function (): void {
    $this->messageBus->register(Command::class, CommandHandlerMissingCommandParameter::class);
})->expectExceptionMessage('Handler parameter is missing: ['.Command::class.' $command]');

it('registers messages', function (): void {
    $messageHandler = fn (Command $command) => null;

    $this->messageBus
        ->register(Command::class, CommandHandler::class)
        ->register(CommandOther::class, $messageHandler);

    $messagesProperty = (new ReflectionObject($this->messageBus))
        ->getProperty('messages');

    $messagesProperty->setAccessible(true);

    expect($messagesProperty->getValue($this->messageBus))
        ->toEqual([
            Command::class => CommandHandler::class,
            CommandOther::class => $messageHandler,
        ]);
});

it('handles commands', function () {
    $this->messageBus
        ->register(Command::class, CommandHandler::class)
        ->send(new Command());

    expect(resolve(CqrsStateContract::class)->getState())
        ->toEqual(Command::class);
});
