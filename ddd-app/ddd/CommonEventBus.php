<?php

declare(strict_types=1);

namespace Ddd;

class CommonEventBus
{
    public function handle(DomainEvent $event): NextCommands
    {
        $policy       = $this->policyOfEvent($event);
        $nextCommands = $policy->when($event);

        collect($nextCommands)->map(static function (NextCommand $nextCommand) {
            CommandPublisher::dispatch($nextCommand->command())->onQueue($nextCommand->recipient());
        });

        return $nextCommands;
    }

    private function policyOfEvent(DomainEvent $event): Policy
    {
        return resolve(get_class($event) . 'Policy');
    }
}
