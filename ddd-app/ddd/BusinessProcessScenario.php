<?php

declare(strict_types=1);


namespace Ddd;


use PHPUnit\Framework\Assert as PHPUnitAssert;

class BusinessProcessScenario extends CommonScenario
{
    private SpyMessageTracer   $messageTracer;

    public function given(Entity ...$entities): self
    {
        collect($entities)->map(
            function (DoctrineEntity $entity) {
                $this->entityManager->persist($entity->clone());
            }
        );

        $this->entityManager->flush();

        return $this;
    }

    public function when(Command $command): self
    {
        $this->messageTracer = new SpyMessageTracer();
        $this->withMockedServices([
            MessageTracer::class => fn($app) => $this->messageTracer,
        ]);

        $commandBus = new CommonCommandBus($this->messageTracer);

        $this->useCaseResponse = $commandBus->handle($command);

        return $this;
    }

    public function then(array $expectations): self
    {
        function assertProcessIsEqual(array $expectations, array $tracedMessages)
        {
            foreach ($expectations as $key => $value) {
                if (empty($value)) {
                    return;
                }

                $expected = array_keys($value);
                $actual   = array_values($tracedMessages[$key]);
                PHPUnitAssert::assertEquals($expected, $actual);

                assertProcessIsEqual($value, $tracedMessages);
            }
        }

        assertProcessIsEqual($expectations, $this->messageTracer->tracedMessages());

        return $this;
    }
}
