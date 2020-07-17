<?php

declare(strict_types=1);


namespace App\Domain\UseCase;


use Ddd\Command;

final class UpdateResource implements Command
{
    private string $id;
    private string $name;
    private string $attr;

    public function __construct(string $id, string $name, string $attr)
    {
        $this->id = $id;
        $this->name = $name;
        $this->attr = $attr;
    }

    public function id(): string
    {
        return $this->id;
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
