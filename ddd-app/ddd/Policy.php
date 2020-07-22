<?php

declare(strict_types=1);

namespace Ddd;

interface Policy
{
    public function when(DomainEvent $event): NextCommands;
}
