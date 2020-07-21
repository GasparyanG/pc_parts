<?php


namespace App\Database\Repositories;


use Doctrine\ORM\EntityRepository;

class MotherboardRepository extends EntityRepository
{
    public function findMemoryTypes()
    {
        $res = $this->createQueryBuilder('a')
            ->select('mt.id, mt.type as name')
            ->leftJoin("App\Database\Entities\MemoryType", 'mt', 'WITH', 'mt=a.memoryType')
            ->groupBy('mt.id')
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res;
        return [];
    }
}