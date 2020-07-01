<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\MDot2Type;
use App\Database\Entities\MoboImage;
use App\Database\Entities\MoboMemorySpeedType;
use App\Database\Entities\MoboPrice;
use App\Database\Entities\Motherboard;
use App\Database\Entities\MotherboardPartNumber;
use App\Database\Entities\MotherboardsUsb;
use App\Database\Entities\OnboardEthernetType;
use App\Database\Entities\SliCrossfireType;

class MoboHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Motherboard::class;

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
        OnboardEthernetType::class => "getOnboardEthernetTypes"
    ];
}