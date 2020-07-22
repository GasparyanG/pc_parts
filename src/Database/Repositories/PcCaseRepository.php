<?php


namespace App\Database\Repositories;


use Doctrine\ORM\EntityRepository;

class PcCaseRepository extends EntityRepository
{
    public function findTypes()
    {
        $res = $this->createQueryBuilder('a')
            ->select('er.id, er.type as name')
            ->leftJoin("App\Database\Entities\CaseType", 'er', 'WITH', 'er=a.caseType')
            ->groupBy('er.id')
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res;
        return [];
    }

    public function findSidePanelWindowTypes()
    {
        $res = $this->createQueryBuilder('a')
            ->select('er.id, er.type as name')
            ->leftJoin("App\Database\Entities\SidePanelWindowType", 'er', 'WITH', 'er=a.sidePanelWindowType')
            ->groupBy('er.id')
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res;
        return [];
    }
}