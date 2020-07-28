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
        "Name" => ["name", "name"],
        "Memory" => ["memory", "memory"],
        "Core Clock" => ["coreClock", "core_clock"],
        "Boost Clock" => ["boostClock", "boost_clock"],
        "Price" => [ResourceHandler::PRICE, ResourceHandler::PRICE]
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
        $this->coreClockFilter($meta);
        $this->boostClockFilter($meta);
        $this->tdpFilter($meta);
        $this->expansionSlotWidthFilter($meta);
    }

    protected function chipsetFilter(Metadata $meta): void
    {
        $chipsets = $this->repo->findChipsets();

        $meta->addFiltrationData([
            Metadata::COLLECTION => $chipsets,
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "Chipset",
            Metadata::FIELD => "chipset_id",
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
            Metadata::FIELD => "memory_type_id",
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

    protected function coreClockFilter(Metadata $meta): void
    {
        $coreClockMinAndMax = $this->repo->findCoreClockMinAndMax();

        $meta->addFiltrationData([
            Metadata::MIN => $coreClockMinAndMax[Metadata::MIN] ?? 0,
            Metadata::MAX => $coreClockMinAndMax[Metadata::MAX] ?? 0,
            Metadata::TYPE => Metadata::RANGE,
            Metadata::GROUPING => Metadata::RANGE_GROUPING,
            Metadata::NAME => "Core Clock",
            Metadata::FIELD => "core_clock",
            Metadata::OPERATOR => strtolower(FilterImplementer::BETWEEN)
        ]);
    }

    protected function boostClockFilter(Metadata $meta): void
    {
        $boostClockMinAndMax = $this->repo->findBoostClockMinAndMax();

        $meta->addFiltrationData([
            Metadata::MIN => $boostClockMinAndMax[Metadata::MIN] ?? 0,
            Metadata::MAX => $boostClockMinAndMax[Metadata::MAX] ?? 0,
            Metadata::TYPE => Metadata::RANGE,
            Metadata::GROUPING => Metadata::RANGE_GROUPING,
            Metadata::NAME => "Boost Clock",
            Metadata::FIELD => "boost_clock",
            Metadata::OPERATOR => strtolower(FilterImplementer::BETWEEN)
        ]);
    }

    protected function tdpFilter(Metadata $meta): void
    {
        $tdpMinAndMax = $this->repo->findTdpMinAndMax();

        $meta->addFiltrationData([
            Metadata::MIN => $tdpMinAndMax[Metadata::MIN] ?? 0,
            Metadata::MAX => $tdpMinAndMax[Metadata::MAX] ?? 0,
            Metadata::TYPE => Metadata::RANGE,
            Metadata::GROUPING => Metadata::RANGE_GROUPING,
            Metadata::NAME => "TDP",
            Metadata::FIELD => "tdp",
            Metadata::OPERATOR => strtolower(FilterImplementer::BETWEEN)
        ]);
    }

    protected function expansionSlotWidthFilter(Metadata $meta): void
    {
        $eswMinAndMax = $this->repo->findExpansionSLotWidthMinAndMax();

        $meta->addFiltrationData([
            Metadata::MIN => $eswMinAndMax[Metadata::MIN] ?? 0,
            Metadata::MAX => $eswMinAndMax[Metadata::MAX] ?? 0,
            Metadata::TYPE => Metadata::RANGE,
            Metadata::GROUPING => Metadata::RANGE_GROUPING,
            Metadata::NAME => "Expansion Slot Width",
            Metadata::FIELD => "expansion_slot_width",
            Metadata::OPERATOR => strtolower(FilterImplementer::BETWEEN)
        ]);
    }
}