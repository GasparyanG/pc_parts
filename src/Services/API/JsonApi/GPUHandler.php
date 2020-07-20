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
    }

    protected function chipsetFilter(Metadata $meta)
    {
        $chipsets = $this->repo->findChipsets();

        $meta->addFiltrationData([
            Metadata::COLLECTION => $chipsets,
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "Chipset",
            Metadata::FIELD => "chipset",
            Metadata::OPERATOR => "in"
        ]);
    }

    protected function memoryTypeFilter(Metadata $meta)
    {
        $memoryTypes = $this->repo->findMemoryTypes();

        $meta->addFiltrationData([
            Metadata::COLLECTION => $memoryTypes,
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "Memory Type",
            Metadata::FIELD => "memoryType",
            Metadata::OPERATOR => "in"
        ]);
    }
}