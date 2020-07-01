<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\Color;
use App\Database\Entities\CoolerImage;
use App\Database\Entities\CoolerPartNumber;
use App\Database\Entities\CoolerPrice;
use App\Database\Entities\CpuSocket;
use App\Database\Entities\Cooler;

class CoolerHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Cooler::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [
        CoolerImage::class => "getCoolerImages",
        CoolerPrice::class => "getCoolerPrices",
        CoolerPartNumber::class => "getPartNumbers",
        CpuSocket::class => "getCpuSockets",
        Color::class => "getColors"
    ];
}