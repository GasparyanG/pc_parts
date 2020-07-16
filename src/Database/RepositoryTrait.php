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

    public function total(): int
    {
        return $this->createQueryBuilder('c')
            ->select('count(c.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findLastLowestPrice(int $id, int $timeInterval, string $name): ?float
    {
        $startDate = time() - $timeInterval;
        $endDate = time();

        $res = null;
        try {
            $res = $this->createQueryBuilder('c')
                ->select("c.price")
                ->where('c.' . $name . '= ' . $id)
                ->andWhere("c.date between " . $startDate . " AND " . $endDate)
                ->orderBy("c.price")
                ->setMaxResults(1)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (\Exception $e) {}

        if (!$res) return null;
        return $res;
    }

    public function findImageName(int $id, string $name): ?string
    {
        $res = null;
        try {
            $res = $this->createQueryBuilder('c')
                ->select("c.fileName")
                ->where('c.' . $name . '= ' . $id)
                ->setMaxResults(1)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (\Exception $e) {}

        if (!$res) return null;
        return $res;
    }

    public function findPartManufacturers(): array
    {
        $res = $this->createQueryBuilder('a')
            ->select('m.id, m.name')
            ->leftJoin("App\Database\Entities\Manufacturer", 'm', 'WITH', 'm=a.manufacturer')
            ->groupBy('m.id')
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res;
        return [];
    }
}