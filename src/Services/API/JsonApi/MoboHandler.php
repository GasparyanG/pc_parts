<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\CpuSocket;
use App\Database\Entities\Manufacturer;
use App\Database\Entities\MDot2Type;
use App\Database\Entities\MemoryType;
use App\Database\Entities\MoboFormFactor;
use App\Database\Entities\MoboImage;
use App\Database\Entities\MoboMemorySpeedType;
use App\Database\Entities\MoboPrice;
use App\Database\Entities\Motherboard;
use App\Database\Entities\MotherboardPartNumber;
use App\Database\Entities\MotherboardsUsb;
use App\Database\Entities\OnboardEthernetType;
use App\Database\Entities\SliCrossfireType;
use App\Database\Entities\WirelessNetworkingType;
use App\Services\API\JsonApi\DataFetching\FilterImplementer;
use App\Services\API\JsonApi\Specification\Metadata;

class MoboHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Motherboard::class;

    /**
     * {@inheritDoc}
     */
    public static $priceEntityName = MoboPrice::class;

    /**
     * {@inheritDoc}
     */
    public static $imageEntityName = MoboImage::class;

    /**
     * {@inheritDoc}
     */
    public static $assocName = "mobo";

    /**
     * {@inheritDoc}
     */
    public static $essentialFields = [
        "Name" => ["name", "name"],
        "Memory Max" => ["mexMemory", "mex_memory", "GB"],
        "Memory Slots" => ["memorySlots", "memory_slots"],
        "Price" => [ResourceHandler::PRICE, ResourceHandler::PRICE, "$"]
    ];


    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [
        MoboImage::class => "getMoboImages",
        MoboPrice::class => "getMoboPrices",
        MotherboardPartNumber::class => "getPartNumbers",
        MoboMemorySpeedType::class => "getMoboMemorySpeedTypes",
        SliCrossfireType::class => "getSliCrossfireTypes",
        MotherboardsUsb::class => "getUsbs",
        MDot2Type::class => "getMDot2Types",
        OnboardEthernetType::class => "getOnboardEthernetTypes",
        Manufacturer::class => "getManufacturer",
        CpuSocket::class => "getCpuSocket",
        MoboFormFactor::class => "getMoboFormFactor",
        MemoryType::class => "getMemoryType",
        WirelessNetworkingType::class => "getWirelessNetworkingType"
    ];

    protected function filtrationData(Metadata $meta): void
    {
        parent::filtrationData($meta);
        $this->memoryTypeFilter($meta);
        $this->maxMemoryFilter($meta);
        $this->memorySlotsFilter($meta);
        $this->wirelessNetworkingTypeFilter($meta);
        $this->chipsetFilter($meta);
        $this->moboFormFactorFilter($meta);
        $this->cpuSocketFilter($meta);
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

    protected function maxMemoryFilter(Metadata $meta): void
    {
        $memoryMinAndMax = $this->repo->findMemoryMinAndMax();

        $meta->addFiltrationData([
            Metadata::MIN => $memoryMinAndMax[Metadata::MIN] ?? 0,
            Metadata::MAX => $memoryMinAndMax[Metadata::MAX] ?? 0,
            Metadata::TYPE => Metadata::RANGE,
            Metadata::GROUPING => Metadata::RANGE_GROUPING,
            Metadata::NAME => "Memory Max",
            Metadata::FIELD => "max_memory",
            Metadata::OPERATOR => strtolower(FilterImplementer::BETWEEN)
        ]);
    }

    protected function memorySlotsFilter(Metadata $meta): void
    {
        $memorySlotsMinAndMax = $this->repo->findMemorySlotsMinAndMax();

        $meta->addFiltrationData([
            Metadata::MIN => $memorySlotsMinAndMax[Metadata::MIN] ?? 0,
            Metadata::MAX => $memorySlotsMinAndMax[Metadata::MAX] ?? 0,
            Metadata::TYPE => Metadata::RANGE,
            Metadata::GROUPING => Metadata::RANGE_GROUPING,
            Metadata::NAME => "Memory Slots",
            Metadata::FIELD => "memory_slots",
            Metadata::OPERATOR => strtolower(FilterImplementer::BETWEEN)
        ]);
    }

    protected function wirelessNetworkingTypeFilter(Metadata $meta): void
    {
        $wirelessNetworkingTypes = $this->repo->findWirelessNetworkingTypes();

        $meta->addFiltrationData([
            Metadata::COLLECTION => $wirelessNetworkingTypes,
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "Wireless Networking",
            Metadata::FIELD => "wireless_networking_type_id",
            Metadata::OPERATOR => strtolower(FilterImplementer::IN)
        ]);
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

    protected function moboFormFactorFilter(Metadata $meta)
    {
        $moboFormFactors = $this->repo->findFormFactors();

        $meta->addFiltrationData([
            Metadata::COLLECTION => $moboFormFactors,
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "Form Factor",
            Metadata::FIELD => "mobo_form_factor_id",
            Metadata::OPERATOR => strtolower(FilterImplementer::IN)
        ]);
    }

    protected function cpuSocketFilter(Metadata $meta)
    {
        $cpuSockets = $this->repo->findCpuSockets();

        $meta->addFiltrationData([
            Metadata::COLLECTION => $cpuSockets,
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "Socket / CPU",
            Metadata::FIELD => "cpu_socket_id",
            Metadata::OPERATOR => strtolower(FilterImplementer::IN)
        ]);
    }
}