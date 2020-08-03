<?php


namespace App\Database\Repositories;


use App\Database\RepositoryTrait;
use Doctrine\ORM\EntityRepository;

class PowerSupplyRepository extends EntityRepository
{
    const TABLE_NAME = "power_supplies";
    use RepositoryTrait;

    public function findEfficiencyRatings()
    {
        $res = $this->createQueryBuilder('a')
            ->select('er.id, er.rating as name')
            ->leftJoin("App\Database\Entities\EfficiencyRating", 'er', 'WITH', 'er=a.efficiencyRating')
            ->groupBy('er.id')
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res;
        return [];
    }

    public function findWattageMinAndMax()
    {
        $res = $this->createQueryBuilder('a')
            ->select("MIN(a.wattage) as min, MAX(a.wattage) as max")
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res[0];
        return [];
    }

    public function findLengthMinAndMax()
    {
        $res = $this->createQueryBuilder('a')
            ->select("MIN(a.length) as min, MAX(a.length) as max")
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res[0];
        return [];
    }

    public function findModularity(): array
    {
        $sql = <<<SQL
select distinct QUOTE(modular) as id, modular as name from power_supplies
SQL;

        $res = $this->_em->getConnection()->query($sql);
        if (!$res) return [];
        return $res->fetchAll();
    }
}