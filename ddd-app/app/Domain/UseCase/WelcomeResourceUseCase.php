<?php

declare(strict_types=1);


namespace App\Domain\UseCase;


use App\Domain\Event\ResourceWelcomed;
use App\Domain\Model\ResourceRepository;
use Ddd\Command;
use Ddd\DomainEvents;
use Ddd\Entities;
use Ddd\UseCase;
use Ddd\UseCaseResponse;
use DomainException;

final class WelcomeResourceUseCase implements UseCase
{
    private ResourceRepository $repository;

    public function __construct(ResourceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param WelcomeResource $command
     */
    public function execute(Command $command): UseCaseResponse
    {
        if (!$resource = $this->repository->findById($command->id())) {
            throw new DomainException("Resource {$command->id()} does not exist");
        }

        $resource->setIsWelcomed(true);

        return UseCaseResponse::new(
            Entities::new($resource),
            DomainEvents::new(new ResourceWelcomed($command->id()))
        );
    }
}
