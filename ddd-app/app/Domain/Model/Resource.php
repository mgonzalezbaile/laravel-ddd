<?php

declare(strict_types=1);


namespace App\Domain\Model;

use Ddd\DoctrineEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="resources")
 */
final class Resource extends DoctrineEntity
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private string $attr;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private bool $isWelcomed = false;

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

    public function isWelcomed(): bool
    {
        return $this->isWelcomed;
    }

    public function setIsWelcomed(bool $isWelcomed): self
    {
        $this->isWelcomed = $isWelcomed;

        return $this;
    }
}
