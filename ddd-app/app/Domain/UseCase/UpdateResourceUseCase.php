<?php

declare(strict_types=1);


namespace App\Domain\UseCase;


use App\Domain\Model\ResourceRepository;
use Ddd\AggregateRootList;
use Ddd\Command;
use Ddd\UseCase;
use Ddd\UseCaseResponse;

final class UpdateResourceUseCase implements UseCase
{
    private ResourceRepository $repository;

    public function __construct(ResourceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param UpdateResource $command
     */
    public function execute(Command $command): UseCaseResponse
    {
        $resource = $this->repository->findById($command->id());

        if(!$resource){
            throw new \DomainException("Resource '{$command->id()}' does not exist");
        }

        $resource
            ->setName($command->name())
            ->setAttr($command->attr());

        return new UseCaseResponse(AggregateRootList::fromAggregateRoots($resource));
    }
}
