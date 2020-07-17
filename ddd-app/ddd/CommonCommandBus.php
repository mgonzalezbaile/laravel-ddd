<?php

declare(strict_types=1);

namespace Ddd;

use LaravelDoctrine\ORM\Facades\EntityManager;

class CommonCommandBus
{
    public function handle(Command $command): UseCaseResponse
    {
        $useCase  = $this->useCaseOfCommand($command);
        $response = $useCase->execute($command);

        collect($response->aggregateRootList())->map(static function (AggregateRoot $aggregateRoot) {
            if (!EntityManager::find(get_class($aggregateRoot), $aggregateRoot->id())) {
                EntityManager::persist($aggregateRoot);
            }

            return $aggregateRoot;
        });

        EntityManager::flush();

        return $response;
    }

    private function useCaseOfCommand(Command $command): UseCase
    {
        return resolve(get_class($command) . 'UseCase');
    }
}
