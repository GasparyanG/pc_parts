<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\Cpu;
use App\Database\Entities\CpuImage;
use App\Database\Entities\CpuPartNumber;
use App\Database\Entities\CpuPrice;
use App\Database\Entities\Manufacturer;

class CPUHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Cpu::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [
        CpuImage::class => "getCpuImages",
        CpuPrice::class => "getCpuPrices",
        CpuPartNumber::class => "getPartNumbers",
        Manufacturer::class => "getManufacturer"
    ];
}