<?php

namespace App\Domain\Event;

use App\Domain\Model\Resource;
use Ddd\DomainEvent;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ResourceCreated implements DomainEvent
{
    use Dispatchable, SerializesModels;

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
