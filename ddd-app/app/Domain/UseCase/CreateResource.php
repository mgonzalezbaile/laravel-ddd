<?php

declare(strict_types=1);


namespace App\Domain\UseCase;


use Ddd\Command;

final class CreateResource implements Command
{
    private string $name;
    private string $attr;

    public function __construct(string $name, string $attr)
    {
        $this->name = $name;
        $this->attr = $attr;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function attr(): string
    {
        return $this->attr;
    }
}
