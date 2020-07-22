<?php

declare(strict_types=1);


namespace Ddd;


final class NextCommand
{
    private Command   $command;
    private string    $recipient;

    public static function new(Command $command, string $recipient = 'default'): self
    {
        return new self($command, $recipient);
    }

    private function __construct(Command $command, string $recipient)
    {
        $this->command   = $command;
        $this->recipient = $recipient;
    }

    public function command(): Command
    {
        return $this->command;
    }

    public function recipient(): string
    {
        return $this->recipient;
    }
}
