<?php

declare(strict_types=1);


namespace Tests;


use App\Domain\Event\AnotherThingDone;
use App\Domain\Event\ResourceCreated;
use App\Domain\Event\ResourceWelcomed;
use App\Domain\Event\SomethingDone;
use App\Domain\UseCase\CreateResource;
use App\Domain\UseCase\DoAnotherThing;
use App\Domain\UseCase\DoSomething;
use App\Domain\UseCase\WelcomeResource;
use Ddd\BusinessProcessScenario;

final class CreateResourceProcessTest extends BusinessProcessScenario
{
    public function testHappyPath(): void
    {
        $entities = [];

        $this
            ->given(...$entities)
            ->when(new CreateResource('some name', 'some attr'))
            ->then([
                CreateResource::class => [
                    ResourceCreated::class => [
                        WelcomeResource::class => [
                            ResourceWelcomed::class => []
                        ],
                        DoSomething::class     => [
                            SomethingDone::class => [
                                DoAnotherThing::class => [
                                    AnotherThingDone::class => []
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
    }
}
