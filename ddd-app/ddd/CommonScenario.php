<?php

declare(strict_types=1);

namespace Ddd;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Tests\TestCase;

abstract class CommonScenario extends TestCase
{
    protected EntityManager $entityManager;
    protected array $mockedServices;

    public function setUp(): void
    {
        parent::setUp();
        $this->entityManager = $this->app['em'];
        $st = new SchemaTool($this->entityManager);
        $classes = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $st->updateSchema($classes);
    }

    public function withMockedServices(array $mockedServices): self
    {
        foreach ($mockedServices as $mockedServiceKey => $mockedServiceValue) {
            $this->app->bind($mockedServiceKey, $mockedServiceValue);
        }

        return $this;
    }
}
