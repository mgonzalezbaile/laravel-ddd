<?php

declare(strict_types=1);

namespace Ddd;

use ArrayIterator;
use IteratorAggregate;

class AggregateRootList implements IteratorAggregate
{
    private array $aggregateRoots;

    private function __construct(array $aggregateRoots)
    {
        $this->aggregateRoots = $aggregateRoots;
    }

    public static function empty(): self
    {
        return new self([]);
    }

    public static function fromAggregateRoots(AggregateRoot ...$aggregateRoots): self
    {
        return new self($aggregateRoots);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->aggregateRoots);
    }

    public function first(): AggregateRoot
    {
        return $this->aggregateRoots[0];
    }

    /**
     * @return AggregateRoot[]
     */
    public function asArray(): array
    {
        return $this->aggregateRoots;
    }

    public function appendAggregateRootList(self $projectionList): self
    {
        return new self(array_merge($this->aggregateRoots, $projectionList->asArray()));
    }

    public function addAggregateRoot(?AggregateRoot $aggregateRoot): self
    {
        return new self(array_filter(array_merge($this->aggregateRoots, [$aggregateRoot])));
    }
}
