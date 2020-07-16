<?php

declare(strict_types=1);


namespace App\Domain\Model;


use Ddd\AggregateRoot;

final class Resource implements AggregateRoot
{
    private string $id;
    private string $name;
    private string $attr;

    public static function new(): self
    {
        return new self();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function attr(): string
    {
        return $this->attr;
    }

    public function setAttr(string $attr): self
    {
        $this->attr = $attr;

        return $this;
    }
}
