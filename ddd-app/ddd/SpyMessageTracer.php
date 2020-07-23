<?php

declare(strict_types=1);


namespace Ddd;


final class SpyMessageTracer implements MessageTracer
{
    private array $tracedMessages = [];

    public function add($originMessage, array $producedMessages): void
    {
        $this->tracedMessages[get_class($originMessage)] = collect($producedMessages)->map(fn($message) => get_class($message))->toArray();
    }

    public function tracedMessages(): array
    {
        return $this->tracedMessages;
    }
}
