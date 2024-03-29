<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\Manufacturer;
use App\Database\Entities\Storage;
use App\Database\Entities\StorageFormFactor;
use App\Database\Entities\StorageImage;
use App\Database\Entities\StorageInterface;
use App\Database\Entities\StoragePartNumber;
use App\Database\Entities\StoragePrice;
use App\Database\Entities\StorageType;
use App\Services\API\JsonApi\DataFetching\FilterImplementer;
use App\Services\API\JsonApi\Specification\Metadata;

class StorageHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    protected static $partName = "Storage";

    /**
     * {@inheritDoc}
     */
    public static $entityName = Storage::class;

    /**
     * {@inheritDoc}
     */
    public static $priceEntityName = StoragePrice::class;

    /**
     * {@inheritDoc}
     */
    public static $imageEntityName = StorageImage::class;

    /**
     * {@inheritDoc}
     */
    public static $assocName = "storage";

    /**
     * {@inheritDoc}
     */
    public static $essentialFields = [
        "Name" => ["name", "name"],
        "Capacity" => ["capacity","capacity", "GB"],
        "Cache" => ["cache","cache", "MB"],
        "Form Factor" => ["formFactor", "form_factor"],
        "Type" => ["type", "type"],
        "Interface" => ["interface", "interface"],
        "Price" => [ResourceHandler::PRICE, ResourceHandler::PRICE, "$"],
    ];

    public function attributes(int $id): array
    {
        $attr = parent::attributes($id);

        $storage = $this->em->getRepository(self::$entityName)->find($id);
        if ($storage) {
            if ($storage->getStorageFormFactor())
                $attr["formFactor"] = $storage->getStorageFormFactor()->getType();
            if ($storage->getStorageType())
                $attr["type"] = $storage->getStorageType()->getType();
            if ($storage->getStorageInterface())
                $attr["interface"] = $storage->getStorageInterface()->getType();
        }

        return $attr;
    }

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [
        StorageImage::class => "getStorageImages",
        StoragePrice::class => "getStoragePrices",
        StoragePartNumber::class => "getPartNumbers",
        Manufacturer::class => "getManufacturer",
        StorageType::class => "getStorageType",
        StorageFormFactor::class => "getStorageFormFactor",
        StorageInterface::class => "getStorageInterface"
    ];

    protected function filtrationData(Metadata $meta): void
    {
        parent::filtrationData($meta);
        $this->typeFIlter($meta);
        $this->capacityFilter($meta);
        $this->cacheFilter($meta);
        $this->formFactorFilter($meta);
        $this->interfaceFilter($meta);
        $this->nvmeFilter($meta);
    }

    protected function typeFilter(Metadata $meta): void
    {
        $types = $this->repo->findtypes();

        $meta->addFiltrationData([
            Metadata::COLLECTION => $types,
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "Type",
            Metadata::FIELD => "storage_type_id",
            Metadata::OPERATOR => strtolower(FilterImplementer::IN)
        ]);
    }

    protected function capacityFilter(Metadata $meta): void
    {
        $capacityMinAndMax = $this->repo->findCapacityMinAndMax();

        $meta->addFiltrationData([
            Metadata::MIN => $capacityMinAndMax[Metadata::MIN] ?? 0,
            Metadata::MAX => $capacityMinAndMax[Metadata::MAX] ?? 0,
            Metadata::TYPE => Metadata::RANGE,
            Metadata::GROUPING => Metadata::RANGE_GROUPING,
            Metadata::STEP => 100,
            Metadata::UNIT => "GB",
            Metadata::NAME => "Capacity",
            Metadata::FIELD => "capacity",
            Metadata::OPERATOR => strtolower(FilterImplementer::BETWEEN)
        ]);
    }

    protected function cacheFilter(Metadata $meta): void
    {
        $cacheMinAndMax = $this->repo->findCacheMinAndMax();

        $meta->addFiltrationData([
            Metadata::MIN => $cacheMinAndMax[Metadata::MIN] ?? 0,
            Metadata::MAX => $cacheMinAndMax[Metadata::MAX] ?? 0,
            Metadata::TYPE => Metadata::RANGE,
            Metadata::GROUPING => Metadata::RANGE_GROUPING,
            Metadata::STEP => 8,
            Metadata::UNIT => "MB",
            Metadata::NAME => "Cache",
            Metadata::FIELD => "cache",
            Metadata::OPERATOR => strtolower(FilterImplementer::BETWEEN)
        ]);
    }

    protected function formFactorFilter(Metadata $meta): void
    {
        $formFactors = $this->repo->findFormFactors();

        $meta->addFiltrationData([
            Metadata::COLLECTION => $formFactors,
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "Form Factor",
            Metadata::FIELD => "storage_form_factor_id",
            Metadata::OPERATOR => strtolower(FilterImplementer::IN)
        ]);
    }

    protected function interfaceFilter(Metadata $meta): void
    {
        $interfaces = $this->repo->findInterfaces();

        $meta->addFiltrationData([
            Metadata::COLLECTION => $interfaces,
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "Interface",
            Metadata::FIELD => "storage_interface_id",
            Metadata::OPERATOR => strtolower(FilterImplementer::IN)
        ]);
    }

    protected function nvmeFilter(Metadata $meta): void
    {
        $meta->addFiltrationData([
            Metadata::COLLECTION => [["id" => 0, "name" => "No"], ["id" => 1, "name" => "Yes"]],
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "NVME",
            Metadata::FIELD => "nvme",
            Metadata::OPERATOR => strtolower(FilterImplementer::IN)
        ]);
    }
}