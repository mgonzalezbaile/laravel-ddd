<?php

declare(strict_types=1);

namespace Ddd;

class UseCaseResponse
{
    private DomainEvents  $domainEvents;
    private Entities      $entities;

    private function __construct(Entities $entities = null, DomainEvents $domainEvents = null)
    {
        $this->domainEvents = $domainEvents ?? DomainEvents::empty();
        $this->entities     = $entities ?? Entities::empty();
    }

    public static function empty(): self
    {
        return new self();
    }

    public static function new(Entities $entities = null, DomainEvents $domainEventList = null): self
    {
        return new self($entities, $domainEventList);
    }

    public function domainEvents(): DomainEvents
    {
        return $this->domainEvents;
    }

    public function entities(): Entities
    {
        return $this->entities;
    }

    public function firstDomainEvent(): DomainEvent
    {
        return $this->domainEvents->first();
    }

    public function firstEntity(): Entity
    {
        return $this->entities->first();
    }
}
