<?php

declare(strict_types=1);

namespace Ddd;

use ArrayIterator;
use IteratorAggregate;

class NextCommands implements IteratorAggregate
{
    /**
     * @var NextCommand
     */
    private $nextCommands;

    private function __construct(array $nextCommands)
    {
        $this->nextCommands = $nextCommands;
    }

    public static function new(NextCommand ...$nextCommands): self
    {
        return new self($nextCommands);
    }

    public static function empty(): self
    {
        return new self([]);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->nextCommands);
    }

    public function asArray(): array
    {
        return $this->nextCommands;
    }

    public function wrappedCommands(): array
    {
        return collect($this->nextCommands)->map(fn(NextCommand $command) => $command->command())->toArray();
    }
}
