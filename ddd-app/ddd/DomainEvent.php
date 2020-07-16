<?php

declare(strict_types=1);

namespace Ddd;

interface DomainEvent
{
    public function id(): string;
}
