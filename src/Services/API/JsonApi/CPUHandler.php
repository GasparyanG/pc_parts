<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\Cpu;
use App\Database\Entities\CpuImage;
use App\Database\Entities\CpuPartNumber;
use App\Database\Entities\CpuPrice;
use App\Services\API\JsonApi\Specification\Relationship;
use App\Services\API\JsonApi\Specification\Resource;

class CPUHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Cpu::class;

    public function relationships(int $id): array
    {
        $cpu = $this->em->getRepository(self::$entityName)->find($id);
        if (!$cpu) return [];

        $relationships = [];
        $relationships[] = $this->relationshipWith($cpu, CpuImage::class, "getCpuImages");
        $relationships[] = $this->relationshipWith($cpu, CpuPrice::class, "getCpuPrices");
        $relationships[] = $this->relationshipWith($cpu, CpuPartNumber::class, "getPartNumbers");

        return $relationships;
    }

    public function included(?string $relToInclude, int $id): array
    {
        // TODO: Implement included() method.
        return [];
    }

    private function relationshipWith($cpu, string $className, string $methodName): array
    {
        $relationship = new Relationship();
        $tableName = $this->em->getClassMetadata($className)->getTableName();
        $relationship->setType($tableName);

        $data = [];
        foreach ($cpu->$methodName() as $cpuImage) {
            $singleItemData = [];
            $singleItemData[Resource::TYPE] = $tableName;
            $singleItemData[Resource::ID] = $cpuImage->getId();
            $data[] = $singleItemData;
        }

        $relationship->setData($data);
        $relationship->arrayRepresentation();
        return $relationship->getRepresentation();
    }
}