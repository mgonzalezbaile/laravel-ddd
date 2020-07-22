<?php

declare(strict_types=1);

namespace Ddd;

use ArrayIterator;
use IteratorAggregate;

class DomainEvents implements IteratorAggregate
{
    /**
     * @var DomainEvent[]
     */
    private array $domainEvents;

    private function __construct(array $domainEvents)
    {
        $this->domainEvents = $domainEvents;
    }

    public static function new(DomainEvent ...$domainEvent): self
    {
        return new self($domainEvent);
    }

    public static function empty(): self
    {
        return new self([]);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->domainEvents);
    }

    public function first(): DomainEvent
    {
        return $this->domainEvents[0];
    }

    public function asArray(): array
    {
        return $this->domainEvents;
    }
}
