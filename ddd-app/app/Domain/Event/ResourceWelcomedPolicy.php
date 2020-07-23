<?php

declare(strict_types=1);


namespace App\Domain\Event;


use Ddd\DomainEvent;
use Ddd\NextCommands;
use Ddd\Policy;

final class ResourceWelcomedPolicy implements Policy
{
    /**
     * @param ResourceWelcomed $event
     */
    public function when(DomainEvent $event): NextCommands
    {
        return NextCommands::empty();
    }
}
