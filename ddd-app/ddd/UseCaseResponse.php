<?php

declare(strict_types=1);

namespace Ddd;

class UseCaseResponse
{
    private DomainEvents  $domainEventList;
    private Entities      $entities;

    public static function empty(): self
    {
        return new self();
    }

    public static function new(Entities $aggregateRootList = null, DomainEvents $domainEventList = null): self
    {
        return new self($aggregateRootList, $domainEventList);
    }

    private function __construct(Entities $aggregateRootList = null, DomainEvents $domainEventList = null)
    {
        $this->domainEventList = $domainEventList ?? DomainEvents::empty();
        $this->entities        = $aggregateRootList ?? Entities::empty();
    }

    public function domainEventList(): DomainEvents
    {
        return $this->domainEventList;
    }

    public function entities(): Entities
    {
        return $this->entities;
    }

    public function firstDomainEvent(): DomainEvent
    {
        return $this->domainEventList->first();
    }

    public function firstEntity(): Entity
    {
        return $this->entities->first();
    }
}
