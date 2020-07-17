<?php

declare(strict_types=1);


namespace App\Domain\Model;


interface ResourceRepository
{
    public function findById(string $id): ?Resource;
}
