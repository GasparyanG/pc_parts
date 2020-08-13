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

    public function findLastLowestPrice(int $id, string $name): ?array
    {
        $res = null;
        $mainTableName = $this->_em->getClassMetadata($this->_entityName)->getTableName();

        $name = $name . "_id";
        $sql = <<<SQL
select price, url, retailer_id as retailer from $mainTableName where $name = $id order by date desc, price asc limit 1
SQL;

        try {
            $res = $this->_em->getConnection()->query($sql);
            if (!$res) return [];
            return $res->fetchAll()[0];
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
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
select distinct QUOTE(sct.type) as id, sct.type as name from sli_crossfire_types sct join $tableName scvc on sct.id=scvc.sli_crossfire_type_id;
SQL;


        $res = $this->_em->getConnection()->query($sql);
        if (!$res) return [];
        return $res->fetchAll();
    }

    public function findFrameSyncTypes(): array
    {
        $meta = Factory::create($this->_entityName);
        [$foreignKey, $tableName] = $meta->get("frame_sync");

        $sql = <<<SQL
select distinct QUOTE(fst.type) as id, fst.type as name from frame_sync_types as fst left join $tableName as fsvc on fsvc.frame_sync_type_id = fst.id;
SQL;


        $res = $this->_em->getConnection()->query($sql);
        if (!$res) return [];
        return $res->fetchAll();
    }

    public function findCPUSocketFilterTypes(): array
    {
        $meta = Factory::create($this->_entityName);
        [$foreignKey, $tableName] = $meta->get("cpu_socket_filter");

        $sql = <<<SQL
select distinct QUOTE(cs.type) as id, cs.type as name from cpu_sockets cs join $tableName as ccs on ccs.cpu_socket_id=cs.id;
SQL;

        $res = $this->_em->getConnection()->query($sql);
        if (!$res) return [];
        return $res->fetchAll();
    }

    public function findModulesTypes(): array
    {
        $meta = Factory::create($this->_entityName);
        [$foreignKey, $tableName] = $meta->get("modules_filter");

        $sql = <<<SQL
select distinct  m.id,  concat(m.amount, ' x ', m.capacity) as name from modules as m join $tableName as ms on ms.$foreignKey=m.id;
SQL;

        $res = $this->_em->getConnection()->query($sql);
        if (!$res) return [];
        return $res->fetchAll();
    }
}