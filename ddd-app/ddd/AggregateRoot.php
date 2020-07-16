<?php

declare(strict_types=1);

namespace Ddd;

interface AggregateRoot
{
    public function id(): string;
}
