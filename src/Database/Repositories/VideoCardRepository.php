<?php


namespace App\Database\Repositories;


use App\Database\RepositoryTrait;
use Doctrine\ORM\EntityRepository;

class VideoCardRepository extends EntityRepository
{
    const TABLE_NAME = "video_cards";
    use RepositoryTrait;

    public function findChipsets()
    {
        $res = $this->createQueryBuilder('a')
            ->select('ch.id, ch.type as name')
            ->leftJoin("App\Database\Entities\Chipset", 'ch', 'WITH', 'ch=a.chipset')
            ->groupBy('ch.id')
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res;
        return [];
    }

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

//    public function findInterfaces()
//    {
//        $res = $this->createQueryBuilder('a')
//            ->select('i.id, i.type as name')
//            ->leftJoin("App\Database\Entities\GpuInterface", 'i', 'WITH', 'i=a.gpuInterface')
//            ->groupBy('i.id')
//            ->getQuery()
//            ->getArrayResult();
//
//        if ($res) return $res;
//        return [];
//    }

    public function findLengthMinANdMax()
    {
        $res = $this->createQueryBuilder('a')
            ->select("MIN(a.length) as min, MAX(a.length) as max")
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res[0];
        return [];
    }
}