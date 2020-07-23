<?php

declare(strict_types=1);


namespace UseCase;


use App\Domain\Event\ResourceWelcomed;
use App\Domain\Model\Resource;
use App\Domain\UseCase\WelcomeResource;
use Ddd\UseCaseScenario;

final class WelcomeResourceUseCaseTest extends UseCaseScenario
{
    public function testShouldWelcomeResource(): void
    {
        $aResource = (new Resource())->setId('some id');
        $this
            ->given($aResource)
            ->when(new WelcomeResource($aResource->id()))
            ->thenExpectEvents(new ResourceWelcomed($aResource->id()))
            ->thenExpectEntities($aResource->setIsWelcomed(true));
    }

    public function testShouldFail_When_ResourceDoesntExist(): void
    {
        $id = 'some id';
        $this
            ->when(new WelcomeResource($id))
            ->thenExpectException(new \DomainException("Resource $id does not exist"));
    }
}
