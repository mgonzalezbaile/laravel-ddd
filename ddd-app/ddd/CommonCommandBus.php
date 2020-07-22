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

        collect($response->entities())->map(static function (Entity $entity) {
            if (!EntityManager::find(get_class($entity), $entity->id())) {
                EntityManager::persist($entity);
            }

            return $entity;
        });

        EntityManager::flush();

        collect($response->domainEventList())->map(static function (DomainEvent $event) {
            EventPublisher::dispatch($event)->onQueue(config('queue.events_queue'));
        });

        return $response;
    }

    private function useCaseOfCommand(Command $command): UseCase
    {
        return resolve(get_class($command) . 'UseCase');
    }
}
