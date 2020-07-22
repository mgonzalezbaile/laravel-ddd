<?php

declare(strict_types=1);


namespace Ddd;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class CommandPublisher implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $input;

    public function __construct($input)
    {
        $this->input = $input;
    }

    public function handle(CommonCommandBus $commandBus): void
    {
        $commandBus->handle($this->input);
    }
}
