<?php


namespace App\Database\Repositories;


use App\Database\RepositoryTrait;
use Doctrine\ORM\EntityRepository;

class CpuRepository extends EntityRepository
{
    const TABLE_NAME = "cpus";
    use RepositoryTrait;

    public function findCoreCountMinAndMax()
    {
        $res = $this->createQueryBuilder('a')
            ->select("MIN(a.coreCount) as min, MAX(a.coreCount) as max")
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res[0];
        return [];
    }

    public function findCoreClockMinAndMax()
    {
        $res = $this->createQueryBuilder('a')
            ->select("MIN(a.coreClock) as min, MAX(a.coreClock) as max")
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res[0];
        return [];
    }

    public function findTdpMinAndMax()
    {
        $res = $this->createQueryBuilder('a')
            ->select("MIN(a.tdp) as min, MAX(a.tdp) as max")
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res[0];
        return [];
    }

    public function findSeriesTypes()
    {
        $res = $this->createQueryBuilder('a')
            ->select('s.id, s.name')
            ->leftJoin("App\Database\Entities\CpuSeries", 's', 'WITH', 's=a.cpuSeries')
            ->groupBy('s.id')
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res;
        return [];
    }

    public function findMicroarchitectureTypes()
    {
        $res = $this->createQueryBuilder('a')
            ->select('m.id, m.name')
            ->leftJoin("App\Database\Entities\Microarchitecture", 'm', 'WITH', 'm=a.microarchitecture')
            ->groupBy('m.id')
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res;
        return [];
    }

    public function findCoreFamilyTypes()
    {
        $res = $this->createQueryBuilder('a')
            ->select('cf.id, cf.name')
            ->leftJoin("App\Database\Entities\CoreFamily", 'cf', 'WITH', 'cf=a.coreFamily')
            ->groupBy('cf.id')
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res;
        return [];
    }
}