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
        "Name" => "name",
        "Price" => ResourceHandler::PRICE,
        "Memory Max" => "mexMemory",
        "Memory Slots" => "memorySlots"
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
}