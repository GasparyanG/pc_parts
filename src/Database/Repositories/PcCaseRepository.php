<?php


namespace App\Database\Repositories;


use App\Database\Entities\Metadata\Factory;
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

    public function findFontPanelUsbTypes(): array
    {
        $meta = Factory::create($this->_entityName);
        [$foreignKey, $tableName] = $meta->get("front_usb_filter");

        $mainTableName = $this->_em->getClassMetadata($this->_entityName)->getTableName();

        $sql = <<<SQL
select distinct u.* from $tableName as cu join usbs as u on u.id=cu.usb_id join $mainTableName as pc on pc.id=cu.$foreignKey;
SQL;

        $res = $this->_em->getConnection()->query($sql);
        if (!$res) return [];
        return $this->prepareUsbs($res->fetchAll());
    }

    private function prepareUsbs(array $usbs): array
    {
        $usbInfoToReturn = [];
        foreach ($usbs as $usb) {
            $singleUsbInfo = [];
            $singleUsbInfo["id"] = $usb["id"];
            $singleUsbInfo["name"] = $this->prepareUsbName($usb);
            $usbInfoToReturn[] = $singleUsbInfo;
        }

        return $usbInfoToReturn;
    }

    private function prepareUsbName(array $usb): ?string
    {
        $name = "";

        if ($usb["version"]) {
            $name .= "USB " . $usb["version"];
            if ($usb["generation"])
                $name .= " Gen " . $usb["generation"];
            if ($usb["type"])
                $name .= " Type " . $usb["type"];
        }

        if (!$name)
            return "None";

        return $name;
    }

    public function findMoboFormFactorTypes(): array
    {
        $meta = Factory::create($this->_entityName);
        [$foreignKey, $tableName] = $meta->get("mobo_form_factor_filter");

        $mainTableName = $this->_em->getClassMetadata($this->_entityName)->getTableName();

        $sql = <<<SQL
select distinct u.id, u.type as name 
  from $tableName as cu 
    join mobo_form_factors as u on u.id=cu.mobo_form_factor_id 
    join $mainTableName as pc on pc.id=cu.$foreignKey;
SQL;

        $res = $this->_em->getConnection()->query($sql);
        if (!$res) return [];
        return $res->fetchAll();
    }
}