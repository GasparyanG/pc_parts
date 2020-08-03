<?php


namespace App\Database\Repositories;


use App\Database\Entities\Metadata\Factory;
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

    public function findSpeedMinAndMax()
    {
        $res = $this->createQueryBuilder('a')
            ->select("MIN(a.speed) as min, MAX(a.speed) as max")
            ->getQuery()
            ->getArrayResult();

        if ($res) return $res[0];
        return [];
    }

    public function findTimingTypes(): array
    {
        $meta = Factory::create($this->_entityName);
        [$foreignKey, $tableName] = $meta->get("timings_filter");

        $sql = <<<SQL
select distinct  m.id, timing as name from timings as m join $tableName as ms on ms.$foreignKey=m.id;
SQL;

        $res = $this->_em->getConnection()->query($sql);
        if (!$res) return [];
        return $res->fetchAll();
    }

    public function findVoltageMinAndMax()
    {
        $sql = <<<SQL
select format(min(voltage), 2) as min, format(max(voltage),2) as max from memories;
SQL;

        $res = $this->_em->getConnection()->query($sql);
        if (!$res) return [];
        return $res->fetchAll()[0];
    }

    public function eccRegisterTypes(): array
    {
        $meta = Factory::create($this->_entityName);
        [$foreignKey, $tableName] = $meta->get("ecc_registers_filter");

        $sql = <<<SQL
select distinct er.id, concat(er.ecc, ' / ', er.registered) as name from ecc_registers as er join $tableName as m on m.$foreignKey = er.id;
SQL;

        $res = $this->_em->getConnection()->query($sql);
        if (!$res) return [];
        return $res->fetchAll();
    }
}