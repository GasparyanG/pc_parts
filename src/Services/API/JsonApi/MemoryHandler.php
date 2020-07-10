<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\Color;
use App\Database\Entities\EccRegister;
use App\Database\Entities\FormFactor;
use App\Database\Entities\Manufacturer;
use App\Database\Entities\Memory;
use App\Database\Entities\MemoryImage;
use App\Database\Entities\MemoryPartNumber;
use App\Database\Entities\MemoryPrice;
use App\Database\Entities\Module;
use App\Database\Entities\Timing;

class MemoryHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Memory::class;

    /**
     * {@inheritDoc}
     */
    public static $priceEntityName = MemoryPrice::class;

    /**
     * {@inheritDoc}
     */
    public static $imageEntityName = MemoryImage::class;

    /**
     * {@inheritDoc}
     */
    public static $assocName = "memory";

    /**
     * {@inheritDoc}
     */
    public static $essentialFields = [
        "Price" => ResourceHandler::PRICE,
        "Speed" => "speed"
    ];

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [
        MemoryImage::class => "getMemoryImages",
        MemoryPrice::class => "getMemoryPrices",
        MemoryPartNumber::class => "getPartNumbers",
        Color::class => "getColors",
        Manufacturer::class => "getManufacturer",
        FormFactor::class => "getFormFactor",
        Module::class => "getModule",
        Timing::class => "getTiming",
        ECCRegister::class => "getECCRegister"
    ];
}