<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\CoreFamily;
use App\Database\Entities\Cpu;
use App\Database\Entities\CpuImage;
use App\Database\Entities\CpuPartNumber;
use App\Database\Entities\CpuPrice;
use App\Database\Entities\CpuSeries;
use App\Database\Entities\CpuSocket;
use App\Database\Entities\IntegratedGraphic;
use App\Database\Entities\LOneCache;
use App\Database\Entities\LThreeCache;
use App\Database\Entities\LTwoCache;
use App\Database\Entities\Manufacturer;
use App\Database\Entities\Microarchitecture;

class CPUHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Cpu::class;

    /**
     * {@inheritDoc}
     */
    public static $priceEntityName = CpuPrice::class;

    /**
     * {@inheritDoc}
     */
    public static $imageEntityName = CpuImage::class;

    /**
     * {@inheritDoc}
     */
    public static $assocName = "cpu";

    /**
     * {@inheritDoc}
     */
    public static $essentialFields = [
        "Name" => "name",
        "Price" => ResourceHandler::PRICE,
        "Core Count" => "coreCount",
        "Core Clock" => "coreClock",
        "Boost Clock" => "boostClock",
        "TDP" => "tdp",
        "SMT" => "smt"
    ];


    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [
        CpuImage::class => "getCpuImages",
        CpuPrice::class => "getCpuPrices",
        CpuPartNumber::class => "getPartNumbers",
        Manufacturer::class => "getManufacturer",
        CpuSocket::class => "getCpuSocket",
        CpuSeries::class => "getCpuSeries",
        Microarchitecture::class => "getMicroarchitecture",
        IntegratedGraphic::class => "getIntegratedGraphic",
        CoreFamily::class => "getCoreFamily",
        LOneCache::class => "getLOneCache",
        LTwoCache::class => "getLTwoCache",
        LThreeCache::class => "getLThreeCache"
    ];
}