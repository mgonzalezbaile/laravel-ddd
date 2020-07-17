<?php

declare(strict_types=1);

namespace Ddd;

use PHPUnit\Framework\Assert as PHPUnitAssert;
use Throwable;

class UseCaseScenario extends CommonScenario
{
    private UseCaseResponse $useCaseResponse;
    private                 $repository;
    private Throwable      $exception;

    public function given(AggregateRoot ...$entities): self
    {
        collect($entities)->map(
            function (DoctrineEntity $entity) {
                $this->entityManager->persist($entity->clone());
            }
        );

        $this->entityManager->flush();

        return $this;
    }

    public function when(Command $command): self
    {
        $commandBus = new CommonCommandBus();

        try {
            $this->useCaseResponse = $commandBus->handle($command);
        } catch (Throwable $exception) {
            $this->exception = $exception;
        }

        return $this;
    }

    public function thenExpectEvents(DomainEvent ...$domainEventList): self
    {
        PHPUnitAssert::assertEquals($domainEventList, $this->useCaseResponse->domainEventList()->asArray());

        return $this;
    }

    public function thenExpectAggregateRoots(AggregateRoot ...$aggregateRootList): self
    {
        collect($this->useCaseResponse->aggregateRootList()->asArray())
            ->map(fn(DoctrineEntity $entity) => $entity->setCreatedAt(null)->setUpdatedAt(null)->setVersion(null));

        PHPUnitAssert::assertEquals($aggregateRootList, $this->useCaseResponse->aggregateRootList()->asArray());

        return $this;
    }

    public function thenExpectException(string $exceptionFqcn): self
    {
        $this->expectException($exceptionFqcn);

        if ($this->exception) {
            throw $this->exception;
        }

        return $this;
    }

    public function thenExpectDeletedAggregateRoots(AggregateRoot ...$aggregateRootList): self
    {
        foreach ($aggregateRootList as $aggregateRoot) {
            PHPUnitAssert::assertNull($this->repository->findOfId($aggregateRoot->id()));
        }

        return $this;
    }
}
