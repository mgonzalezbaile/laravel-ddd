<?php

declare(strict_types=1);

namespace Ddd;

interface UuidGenerator
{
    public function v4(): string;

    public function v3(string $fromString): string;
}
