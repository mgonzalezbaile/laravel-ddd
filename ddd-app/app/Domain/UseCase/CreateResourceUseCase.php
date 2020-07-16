<?php

namespace App\Domain\UseCase;

use App\Domain\Event\ResourceCreated;
use App\Domain\Model\Resource;
use Ddd\AggregateRootList;
use Ddd\Command;
use Ddd\DomainEventsList;
use Ddd\UseCase;
use Ddd\UseCaseResponse;
use Ddd\UuidGenerator;

final class CreateResourceUseCase implements UseCase
{
    private UuidGenerator $uuidGenerator;

    public function __construct(UuidGenerator $uuidGenerator)
    {
        $this->uuidGenerator = $uuidGenerator;
    }

    /**
     * @param CreateResource $command
     */
    public function execute(Command $command): UseCaseResponse
    {
        $resource = Resource::new()
            ->setId($this->uuidGenerator->v4())
            ->setName($command->name())
            ->setAttr($command->attr());

        return new UseCaseResponse(
            AggregateRootList::fromAggregateRoots($resource),
            DomainEventsList::fromDomainEvents(new ResourceCreated($resource))
        );
    }
}
