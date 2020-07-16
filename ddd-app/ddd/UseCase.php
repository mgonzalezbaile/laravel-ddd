<?php

declare(strict_types=1);

namespace Ddd;

interface UseCase
{
    public function execute(Command $command): UseCaseResponse;
}
