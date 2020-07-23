<?php

declare(strict_types=1);


namespace App\Domain\Event;


use App\Domain\UseCase\DoAnotherThing;
use Ddd\DomainEvent;
use Ddd\NextCommand;
use Ddd\NextCommands;
use Ddd\Policy;

final class SomethingDonePolicy implements Policy
{
    /**
     * @param ResourceWelcomed $event
     */
    public function when(DomainEvent $event): NextCommands
    {
        return NextCommands::new(
            NextCommand::new(new DoAnotherThing(), config('queue.events_queue')),
        );
    }
}
