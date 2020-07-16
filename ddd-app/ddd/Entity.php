<?php


namespace Ddd;


class Entity
{
    public function clone(): self
    {
        return clone $this;
    }
}
