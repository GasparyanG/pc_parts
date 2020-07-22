<?php


namespace App\Database\Repositories;


use App\Database\RepositoryTrait;
use Doctrine\ORM\EntityRepository;

class StorageRepository extends EntityRepository
{
    const TABLE_NAME = "storages";
    use RepositoryTrait;

    public function findTypes()
    {
        $res = $this->createQueryBuilder('a')
            ->select('st.id, st.type as name')
            ->leftJoin("App\Database\Entities\StorageType", 'st', 'WITH', 'st=a.storageType')
            ->groupBy('st.id')
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res;
        return [];
    }

    public function findFormFactors()
    {
        $res = $this->createQueryBuilder('a')
            ->select('sff.id, sff.type as name')
            ->leftJoin("App\Database\Entities\StorageFormFactor", 'sff', 'WITH', 'sff=a.storageFormFactor')
            ->groupBy('sff.id')
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res;
        return [];
    }

    public function findInterfaces()
    {
        $res = $this->createQueryBuilder('a')
            ->select('si.id, si.type as name')
            ->leftJoin("App\Database\Entities\StorageInterface", 'si', 'WITH', 'si=a.storageInterface')
            ->groupBy('si.id')
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res;
        return [];
    }

    public function findCapacityMinAndMax()
    {
        $res = $this->createQueryBuilder('a')
            ->select("MIN(a.capacity) as min, MAX(a.capacity) as max")
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res[0];
        return [];
    }

    public function findCacheMinAndMax()
    {
        $res = $this->createQueryBuilder('a')
            ->select("MIN(a.cache) as min, MAX(a.cache) as max")
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res[0];
        return [];
    }
}