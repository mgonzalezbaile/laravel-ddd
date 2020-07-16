<?php

declare(strict_types=1);

namespace Ddd;

use Ramsey\Uuid\Uuid;

final class RamseyUuidGenerator implements UuidGenerator
{
    public function v4(): string
    {
        return Uuid::uuid4()->toString();
    }

    public function v3(string $fromString): string
    {
        return Uuid::uuid3(Uuid::NAMESPACE_DNS, $fromString)->toString();
    }
}
