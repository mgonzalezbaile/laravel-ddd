<?php

namespace Tests\UseCase;

use App\Domain\Model\Resource;
use App\Domain\UseCase\UpdateResource;
use Ddd\FakeUuidGenerator;
use Ddd\UseCaseScenario;
use Ddd\UuidGenerator;

class UpdateResourceUseCaseTest extends UseCaseScenario
{
    public function testShouldUpdateResource(): void
    {
        $id        = 'some id';
        $aResource = Resource::new()
            ->setId($id)
            ->setName('some name')
            ->setAttr('some attr');

        $newName = 'new name';
        $newAttr    = 'new attr';
        $this
            ->withMockedServices([UuidGenerator::class => FakeUuidGenerator::class])
            ->given($aResource)
            ->when(new UpdateResource($id, $newName, $newAttr))
            ->thenExpectAggregateRoots($aResource->setName($newName)->setAttr($newAttr));
    }

    public function testShouldFail_When_ResourceDoesntExist(): void
    {
        $name = 'some name';
        $attr = 'some attr';
        $id = 'some id';

        $this
            ->withMockedServices([UuidGenerator::class => FakeUuidGenerator::class])
            ->when(new UpdateResource($id, $name, $attr))
            ->thenExpectException(\DomainException::class);
    }
}
