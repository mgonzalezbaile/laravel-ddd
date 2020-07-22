<?php

declare(strict_types=1);

namespace Ddd;

use ArrayIterator;
use IteratorAggregate;

class Entities implements IteratorAggregate
{
    private array $entities;

    private function __construct(array $entities)
    {
        $this->entities = $entities;
    }

    public static function empty(): self
    {
        return new self([]);
    }

    public static function new(Entity ...$entities): self
    {
        return new self($entities);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->entities);
    }

    public function first(): Entity
    {
        return $this->entities[0];
    }

    /**
     * @return Entity[]
     */
    public function asArray(): array
    {
        return $this->entities;
    }

    public function appendEntities(Entities $entities): self
    {
        return new self(array_merge($this->entities, $entities->asArray()));
    }

    public function addEntity(?Entity $entity): self
    {
        return new self(array_filter(array_merge($this->entities, [$entity])));
    }
}
