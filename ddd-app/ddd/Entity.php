<?php


namespace Ddd;


abstract class Entity
{
    public function clone(): self
    {
        return clone $this;
    }

    abstract public function id(): string;
}
