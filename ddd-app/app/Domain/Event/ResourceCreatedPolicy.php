<?php

declare(strict_types=1);


namespace App\Domain\Event;


use App\Domain\UseCase\DoSomething;
use App\Domain\UseCase\WelcomeResource;
use Ddd\DomainEvent;
use Ddd\NextCommand;
use Ddd\NextCommands;
use Ddd\Policy;

final class ResourceCreatedPolicy implements Policy
{
    /**
     * @param ResourceCreated $event
     */
    public function when(DomainEvent $event): NextCommands
    {
        return NextCommands::new(
            NextCommand::new(new WelcomeResource($event->id()), config('queue.events_queue')),
            NextCommand::new(new DoSomething(), config('queue.events_queue')),
        );
    }
}
