<?php

declare(strict_types=1);


namespace App\Infrastructure\Output\Persistence;


use App\Domain\Model\Resource;
use App\Domain\Model\ResourceRepository;
use Doctrine\ORM\EntityRepository;

final class DoctrineResourceRepository extends EntityRepository implements ResourceRepository
{
    public function findById(string $id): ?Resource
    {
        return $this->find($id);
    }
}
