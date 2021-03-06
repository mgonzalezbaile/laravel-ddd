<?php

declare(strict_types=1);


namespace App\Domain\UseCase;


use Ddd\Command;

final class WelcomeResource implements Command
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }
}
