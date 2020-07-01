<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\Color;
use App\Database\Entities\ExternalPowerType;
use App\Database\Entities\FrameSyncType;
use App\Database\Entities\GpuCoolingType;
use App\Database\Entities\GpuImage;
use App\Database\Entities\GpuPartNumber;
use App\Database\Entities\GpuPort;
use App\Database\Entities\GpuPrice;
use App\Database\Entities\SliCrossfireType;
use App\Database\Entities\VideoCard;

class GPUHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = VideoCard::class;

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
        Color::class => "getColors"
    ];
}