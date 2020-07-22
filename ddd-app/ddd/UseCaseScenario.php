<?php

declare(strict_types=1);

namespace Ddd;

use PHPUnit\Framework\Assert as PHPUnitAssert;
use Throwable;

class UseCaseScenario extends CommonScenario
{
    private UseCaseResponse  $useCaseResponse;
    private                  $repository;
    private ?Throwable       $exception = null;

    public function given(Entity ...$entities): self
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
        if ($this->exception) {
            throw $this->exception;
        }

        PHPUnitAssert::assertEquals($domainEventList, $this->useCaseResponse->domainEventList()->asArray());

        return $this;
    }

    public function thenExpectAggregateRoots(Entity ...$aggregateRootList): self
    {
        if ($this->exception) {
            throw $this->exception;
        }

        collect($this->useCaseResponse->entities()->asArray())
            ->map(fn(DoctrineEntity $entity) => $entity->setCreatedAt(null)->setUpdatedAt(null)->setVersion(null));

        PHPUnitAssert::assertEquals($aggregateRootList, $this->useCaseResponse->entities()->asArray());

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

    public function thenExpectDeletedAggregateRoots(Entity ...$entities): self
    {
        foreach ($entities as $entity) {
            PHPUnitAssert::assertNull($this->repository->findOfId($entity->id()));
        }

        return $this;
    }
}
