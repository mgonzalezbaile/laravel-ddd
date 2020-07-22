<?php

declare(strict_types=1);


namespace Ddd;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class EventPublisher implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $input;

    public function __construct($input)
    {
        $this->input = $input;
    }

    public function handle(CommonEventBus $eventBus): void
    {
        $eventBus->handle($this->input);
    }
}
