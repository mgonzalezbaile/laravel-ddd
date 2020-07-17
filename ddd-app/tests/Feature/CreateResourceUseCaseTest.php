<?php

namespace Tests\Feature;

use App\Domain\Event\ResourceCreated;
use App\Domain\Model\Resource;
use App\Domain\UseCase\CreateResource;
use Ddd\FakeUuidGenerator;
use Ddd\UseCaseScenario;
use Ddd\UuidGenerator;

class CreateResourceUseCaseTest extends UseCaseScenario
{
    public function testShouldCreateResource(): void
    {
        $name = 'some name';
        $attr = 'some attr';

        $this
            ->withMockedServices([UuidGenerator::class => FakeUuidGenerator::class])
            ->when(new CreateResource($name, $attr))
            ->thenExpectAggregateRoots(
                $resource = Resource::new()
                    ->setId(FakeUuidGenerator::DEFAULT)
                    ->setName($name)
                    ->setAttr($attr)
            )
            ->thenExpectEvents(new ResourceCreated($resource));
    }
}
