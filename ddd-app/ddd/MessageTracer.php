<?php

declare(strict_types=1);


namespace Ddd;


interface MessageTracer
{
    public function add($originMessage, array $producedMessages): void;
}
