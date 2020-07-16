<?php


namespace Ddd;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
abstract class DoctrineEntity extends Entity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", nullable=true)
     */
    protected string $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected ?DateTimeInterface $createdAt = null;

    /**
     * @ORM\Column(type="datetime")
     */
    protected ?DateTimeInterface $updatedAt = null;

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $isDeleted = false;

    /**
     * @ORM\Version @ORM\Column(type="integer")
     */
    private $version;

    public function createdAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function updatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function isDeleted(): bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    public function version()
    {
        return $this->version;
    }

    public function setVersion($version): self
    {
        $this->version = $version;

        return $this;
    }

    /** @ORM\PreUpdate */
    public function beforeUpdate()
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    /** @ORM\PrePersist() */
    public function beforeCreate()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
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
}
