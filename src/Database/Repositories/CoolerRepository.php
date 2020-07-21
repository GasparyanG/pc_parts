<?php


namespace App\Database\Repositories;


use Doctrine\ORM\EntityRepository;

class CoolerRepository extends EntityRepository
{
    public function findBearingTypes()
    {
        $res = $this->createQueryBuilder('a')
            ->select('bt.id, bt.type as name')
            ->leftJoin("App\Database\Entities\BearingType", 'bt', 'WITH', 'bt=a.bearingType')
            ->groupBy('bt.id')
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res;
        return [];
    }
}