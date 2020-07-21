<?php


namespace App\Database\Repositories;


use App\Database\RepositoryTrait;
use Doctrine\ORM\EntityRepository;

class MemoryRepository extends EntityRepository
{
    const TABLE_NAME = "memories";
    use RepositoryTrait;

    public function findFormFactors()
    {
        $res = $this->createQueryBuilder('a')
            ->select('ff.id, ff.type as name')
            ->leftJoin("App\Database\Entities\FormFactor", 'ff', 'WITH', 'ff=a.formFactor')
            ->groupBy('ff.id')
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res;
        return [];
    }
}