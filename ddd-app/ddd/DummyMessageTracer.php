<?php

declare(strict_types=1);


namespace Ddd;


final class DummyMessageTracer implements MessageTracer
{
    public function add($originMessage, array $producedMessages): void
    {
        //
    }
}
