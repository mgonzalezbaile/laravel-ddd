<?php

declare(strict_types=1);


namespace App\Domain\UseCase;


use Ddd\Command;
use Ddd\UseCase;
use Ddd\UseCaseResponse;

final class WelcomeResourceUseCase implements UseCase
{
    /**
     * @param WelcomeResource $command
     */
    public function execute(Command $command): UseCaseResponse
    {
        echo "Welcome Resource!";

        return UseCaseResponse::empty();
    }
}
