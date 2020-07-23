<?php

declare(strict_types=1);

namespace Ddd;

class CommonEventBus
{
    private MessageTracer $messageTracer;

    public function __construct(MessageTracer $messageTracer)
    {
        $this->messageTracer = $messageTracer;
    }

    public function handle(DomainEvent $event): NextCommands
    {
        $policy = $this->policyOfEvent($event);
        if (!$policy) {
            return NextCommands::empty();
        }

        $nextCommands = $policy->when($event);

        $this->messageTracer->add($event, $nextCommands->wrappedCommands());

        collect($nextCommands)->map(static function (NextCommand $nextCommand) {
            CommandPublisher::dispatch($nextCommand->command())->onQueue($nextCommand->recipient());
        });

        return $nextCommands;
    }

    private function policyOfEvent(DomainEvent $event): ?Policy
    {
        $policyClass = get_class($event) . 'Policy';

        if (!class_exists($policyClass)) {
            return null;
        }

        return resolve($policyClass);
    }
}
