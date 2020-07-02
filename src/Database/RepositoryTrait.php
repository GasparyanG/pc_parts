<?php


namespace App\Database;


use Doctrine\ORM\Query;

trait RepositoryTrait
{
    public function findAsArray(int $id): array
    {
        $query = $this->createQueryBuilder('c')
            ->where('c.id = ' . $id)
            ->getQuery();
        if (!isset($query->getResult(Query::HYDRATE_ARRAY)[0])) return [];
        return $query->getResult(Query::HYDRATE_ARRAY)[0];
    }

    public function findViaPagination(int $offset, int $limit): ?iterable
    {
        return $this->createQueryBuilder('c')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}