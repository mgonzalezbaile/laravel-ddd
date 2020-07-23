<?php

declare(strict_types=1);

namespace Ddd;

use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Assert as PHPUnitAssert;
use Throwable;

abstract class UseCaseScenario extends CommonScenario
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
        Queue::fake();
        $commandBus = new CommonCommandBus(new DummyMessageTracer());

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

        PHPUnitAssert::assertEquals($domainEventList, $this->useCaseResponse->domainEvents()->asArray());

        return $this;
    }

    public function thenExpectEntities(Entity ...$aggregateRootList): self
    {
        if ($this->exception) {
            throw $this->exception;
        }

        collect($this->useCaseResponse->entities()->asArray())
            ->map(fn(DoctrineEntity $entity) => $entity->setCreatedAt(null)->setUpdatedAt(null)->setVersion(null));

        PHPUnitAssert::assertEquals($aggregateRootList, $this->useCaseResponse->entities()->asArray());

        return $this;
    }

    public function thenExpectException(\Throwable $exception): self
    {
        if ($this->exception) {
            PHPUnitAssert::assertEquals($exception, $this->exception);
        }

        return $this;
    }
}
