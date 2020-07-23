<?php

declare(strict_types=1);

namespace Ddd;

use LaravelDoctrine\ORM\Facades\EntityManager;

class CommonCommandBus
{
    private MessageTracer $messageTracer;

    public function __construct(MessageTracer $messageTracer)
    {
        $this->messageTracer = $messageTracer;
    }

    public function handle(Command $command): UseCaseResponse
    {
        $useCase  = $this->useCaseOfCommand($command);
        $response = $useCase->execute($command);

        $this->messageTracer->add($command, $response->domainEvents()->asArray());

        collect($response->entities())->map(static function (Entity $entity) {
            if (!EntityManager::find(get_class($entity), $entity->id())) {
                EntityManager::persist($entity);
            }

            return $entity;
        });

        EntityManager::flush();

        collect($response->domainEvents())->map(static function (DomainEvent $event) use ($command) {
            EventPublisher::dispatch($event)->onQueue(config('queue.events_queue'));
        });

        return $response;
    }

    private function useCaseOfCommand(Command $command): UseCase
    {
        return resolve(get_class($command) . 'UseCase');
    }
}
