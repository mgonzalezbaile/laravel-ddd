<?php

namespace App\Domain\Event;

use Ddd\DomainEvent;

class AnotherThingDone implements DomainEvent
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }
}
