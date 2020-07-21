<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\Color;
use App\Database\Entities\ExternalPowerType;
use App\Database\Entities\FrameSyncType;
use App\Database\Entities\GpuCoolingType;
use App\Database\Entities\GpuImage;
use App\Database\Entities\GpuInterface;
use App\Database\Entities\GpuPartNumber;
use App\Database\Entities\GpuPort;
use App\Database\Entities\GpuPrice;
use App\Database\Entities\Manufacturer;
use App\Database\Entities\MemoryType;
use App\Database\Entities\SliCrossfireType;
use App\Database\Entities\VideoCard;
use App\Services\API\JsonApi\DataFetching\FilterImplementer;
use App\Services\API\JsonApi\Specification\Metadata;

class GPUHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = VideoCard::class;

    /**
     * {@inheritDoc}
     */
    public static $priceEntityName = GpuPrice::class;

    /**
     * {@inheritDoc}
     */
    public static $imageEntityName = GpuImage::class;

    /**
     * {@inheritDoc}
     */
    public static $assocName = "gpu";

    /**
     * {@inheritDoc}
     */
    public static $essentialFields = [
        "Name" => "name",
        "Memory" => "memory",
        "Core Clock" => "coreClock",
        "Boost Clock" => "boostClock",
        "Price" => ResourceHandler::PRICE
        // TODO
        // "Chipset" => "chipset",
        // "Color" => "color,
        // "Interface" => "interface"
    ];

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [
        GpuImage::class => "getGpuImages",
        GpuPrice::class => "getGpuPrices",
        GpuPartNumber::class => "getPartNumbers",
        SliCrossfireType::class => "getSliCrossfireTypes",
        FrameSyncType::class => "getFrameSyncType",
        ExternalPowerType::class => "getExternalPowerTypes",
        GpuCoolingType::class => "getGpuCoolingTypes",
        GpuPort::class => "getGpuPorts",
        Color::class => "getColors",
        Manufacturer::class => "getManufacturer",
        MemoryType::class => "getMemoryType",
        GpuInterface::class => "getGpuInterface"
    ];

    protected function filtrationData(Metadata $meta): void
    {
        parent::filtrationData($meta);
        $this->chipsetFilter($meta);
        $this->memoryTypeFilter($meta);
        $this->lengthFilter($meta);
        $this->memoryFilter($meta);
    }

    protected function chipsetFilter(Metadata $meta): void
    {
        $chipsets = $this->repo->findChipsets();

        $meta->addFiltrationData([
            Metadata::COLLECTION => $chipsets,
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "Chipset",
            Metadata::FIELD => "chipset",
            Metadata::OPERATOR => strtolower(FilterImplementer::IN)
        ]);
    }

    protected function memoryTypeFilter(Metadata $meta): void
    {
        $memoryTypes = $this->repo->findMemoryTypes();

        $meta->addFiltrationData([
            Metadata::COLLECTION => $memoryTypes,
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "Memory Type",
            Metadata::FIELD => "memoryType",
            Metadata::OPERATOR => strtolower(FilterImplementer::IN)
        ]);
    }

    protected function lengthFilter(Metadata $meta): void
    {
        $lengthMinAndMax = $this->repo->findLengthMinAndMax();

        $meta->addFiltrationData([
            Metadata::MIN => $lengthMinAndMax[Metadata::MIN] ?? 0,
            Metadata::MAX => $lengthMinAndMax[Metadata::MAX] ?? 0,
            Metadata::TYPE => Metadata::RANGE,
            Metadata::GROUPING => Metadata::RANGE_GROUPING,
            Metadata::NAME => "Length",
            Metadata::FIELD => "length",
            Metadata::OPERATOR => strtolower(FilterImplementer::BETWEEN)
        ]);
    }

    protected function memoryFilter(Metadata $meta): void
    {
        $memoryMinAndMax = $this->repo->findMemoryMinAndMax();

        $meta->addFiltrationData([
            Metadata::MIN => $memoryMinAndMax[Metadata::MIN] ?? 0,
            Metadata::MAX => $memoryMinAndMax[Metadata::MAX] ?? 0,
            Metadata::TYPE => Metadata::RANGE,
            Metadata::GROUPING => Metadata::RANGE_GROUPING,
            Metadata::NAME => "Memory",
            Metadata::FIELD => "memory",
            Metadata::OPERATOR => strtolower(FilterImplementer::BETWEEN)
        ]);
    }

//    protected function interface(Metadata $meta)
//    {
//        $interfaces = $this->repo->findInterfaces();
//
//        $meta->addFiltrationData([
//            Metadata::COLLECTION => $interfaces,
//            Metadata::TYPE => Metadata::CHECKBOX,
//            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
//            Metadata::NAME => "Interface",
//            Metadata::FIELD => "gpuInterface",
//            Metadata::OPERATOR => FilterImplementer::strtolower(self::IN)
//        ]);
//    }
}