<?php

declare(strict_types=1);


namespace App\Domain\UseCase;


use App\Domain\Event\AnotherThingDone;
use Ddd\Command;
use Ddd\DomainEvents;
use Ddd\Entities;
use Ddd\UseCase;
use Ddd\UseCaseResponse;

final class DoAnotherThingUseCase implements UseCase
{
    public function execute(Command $command): UseCaseResponse
    {
        return UseCaseResponse::new(
            Entities::empty(),
            DomainEvents::new(new AnotherThingDone('some id')),
        );
    }
}
