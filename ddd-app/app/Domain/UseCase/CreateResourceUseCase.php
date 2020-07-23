<?php

namespace App\Domain\UseCase;

use App\Domain\Event\ResourceCreated;
use App\Domain\Model\Resource;
use Ddd\Command;
use Ddd\DomainEvents;
use Ddd\Entities;
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

        return UseCaseResponse::new(
            Entities::new($resource),
            DomainEvents::new(new ResourceCreated($resource))
        );
    }
}
