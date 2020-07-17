<?php

declare(strict_types=1);

namespace Ddd;

final class FakeUuidGenerator implements UuidGenerator
{
    public const DEFAULT = '4f877bd4-52bd-403d-8c3d-a030b51453aa';

    private string $uuid;

    public static function withUuid(string $uuid): self
    {
        return new self($uuid);
    }

    private function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public function v4(): string
    {
        return $this->uuid;
    }

    public function v3(string $fromString): string
    {
        return $this->uuid;
    }
}
