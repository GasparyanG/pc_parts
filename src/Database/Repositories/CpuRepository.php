<?php


namespace App\Database\Repositories;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class CpuRepository extends EntityRepository
{
    const TABLE_NAME = "cpus";

    public function findAsArray(int $id): array
    {
        $query = $this->createQueryBuilder('c')
            ->where('c.id = ' . $id)
            ->getQuery();
        if (!isset($query->getResult(Query::HYDRATE_ARRAY)[0])) return [];
        return $query->getResult(Query::HYDRATE_ARRAY)[0];
    }
}