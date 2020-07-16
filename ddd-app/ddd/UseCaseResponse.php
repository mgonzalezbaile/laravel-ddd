<?php

declare(strict_types=1);

namespace Ddd;

class UseCaseResponse
{
    private DomainEventsList  $domainEventList;
    private AggregateRootList $aggregateRootList;

    public static function empty(): self
    {
        return new self();
    }

    public function __construct(AggregateRootList $aggregateRootList = null, DomainEventsList $domainEventList = null)
    {
        $this->domainEventList   = $domainEventList ?? DomainEventsList::empty();
        $this->aggregateRootList = $aggregateRootList ?? AggregateRootList::empty();
    }

    public function domainEventList(): DomainEventsList
    {
        return $this->domainEventList;
    }

    public function aggregateRootList(): AggregateRootList
    {
        return $this->aggregateRootList;
    }

    public function firstDomainEvent(): DomainEvent
    {
        return $this->domainEventList->first();
    }

    public function firstAggregateRoot(): AggregateRoot
    {
        return $this->aggregateRootList->first();
    }
}
