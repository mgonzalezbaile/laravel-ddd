<?php

declare(strict_types=1);


namespace App\Domain\Model;

use Ddd\DoctrineEntity;
use Doctrine\ORM\Mapping AS ORM;
use Ddd\AggregateRoot;

/**
 * @ORM\Entity
 * @ORM\Table(name="resources")
 */
final class Resource extends DoctrineEntity implements AggregateRoot
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private string $attr;

    public static function new(): self
    {
        return new self();
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
