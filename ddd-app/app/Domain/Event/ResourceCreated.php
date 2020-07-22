<?php

namespace App\Domain\Event;

use App\Domain\Model\Resource;
use Ddd\DomainEvent;

class ResourceCreated implements DomainEvent
{
    private Resource $resource;

    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
    }

    public function id(): string
    {
        return $this->resource->id();
    }
}
