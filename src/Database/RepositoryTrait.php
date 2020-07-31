<?php


namespace App\Database;


use App\Database\Entities\Metadata\Factory;
use App\Database\Repositories\ColorRepository;
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

    public function findLastLowestPrice(int $id, string $name): ?float
    {
        $res = null;
        try {
            $res = $this->createQueryBuilder('c')
                ->select("c.price")
                ->where('c.' . $name . '= ' . $id)
                ->orderBy("c.date DESC")
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

    public function findPartColors(): array
    {
        $meta = Factory::create($this->_entityName);
        [$foreignKey, $tableName] = $meta->get("color");
        $mainTableName = $this->_em->getClassMetadata($this->_entityName)->getTableName();

        $colorSeparator = ColorRepository::COLOR_SEPARATOR;

        $sql = <<<SQL
select QUOTE(j.name) as id, j.name as name
from $mainTableName as a
         left join (select mb.id, group_concat(distinct  c.name order by c.name separator $colorSeparator) as name
                    from $tableName as mc
                             left join $mainTableName as mb on mc.$foreignKey = mb.id
                             left join colors as c on c.id = mc.color_id
                    group by mb.id) as j on j.id = a.id
group by j.name;
SQL;


        $res = $this->_em->getConnection()->query($sql);
        if (!$res) return [];
        return $res->fetchAll();
    }

    public function findSliCrossfireTypes(): array
    {
        $meta = Factory::create($this->_entityName);
        [$foreignKey, $tableName] = $meta->get("sli_crossfire");

        $sql = <<<SQL
select distinct sct.id as id, sct.type as name from sli_crossfire_types sct join $tableName scvc on sct.id=scvc.sli_crossfire_type_id;
SQL;


        $res = $this->_em->getConnection()->query($sql);
        if (!$res) return [];
        return $res->fetchAll();
    }
}