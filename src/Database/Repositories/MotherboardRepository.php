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

    public function findMemoryMinAndMax()
    {
        $res = $this->createQueryBuilder('a')
            ->select("MIN(a.maxMemory) as min, MAX(a.maxMemory) as max")
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res[0];
        return [];
    }

    public function findMemorySlotsMinAndMax()
    {
        $res = $this->createQueryBuilder('a')
            ->select("MIN(a.memorySlots) as min, MAX(a.memorySlots) as max")
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res[0];
        return [];
    }

    public function findWirelessNetworkingTypes()
    {
        $res = $this->createQueryBuilder('a')
            ->select('wnt.id, wnt.type as name')
            ->leftJoin("App\Database\Entities\WirelessNetworkingType", 'wnt', 'WITH', 'wnt=a.wirelessNetworkingType')
            ->groupBy('wnt.id')
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res;
        return [];
    }

    public function findChipsets()
    {
        $res = $this->createQueryBuilder('a')
            ->select('cs.id, cs.type as name')
            ->leftJoin("App\Database\Entities\Chipset", 'cs', 'WITH', 'cs=a.chipset')
            ->groupBy('cs.id')
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res;
        return [];
    }

    public function findFormFactors()
    {
        $res = $this->createQueryBuilder('a')
            ->select('mff.id, mff.type as name')
            ->leftJoin("App\Database\Entities\MoboFormFactor", 'mff', 'WITH', 'mff=a.moboFormFactor')
            ->groupBy('mff.id')
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res;
        return [];
    }

    public function findCpuSockets()
    {
        $res = $this->createQueryBuilder('a')
            ->select('cs.id, cs.type as name')
            ->leftJoin("App\Database\Entities\CpuSocket", 'cs', 'WITH', 'cs=a.cpuSocket')
            ->groupBy('cs.id')
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res;
        return [];
    }
}