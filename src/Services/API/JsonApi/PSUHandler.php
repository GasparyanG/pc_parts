<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\Color;
use App\Database\Entities\PowerSupply;
use App\Database\Entities\PsuConnector;
use App\Database\Entities\PsuImage;
use App\Database\Entities\PsuPartNumber;
use App\Database\Entities\PsuPrice;

class PSUHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = PowerSupply::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [
        PsuImage::class => "getPsuImages",
        PsuPrice::class => "getPsuPrices",
        PsuPartNumber::class => "getPartNumbers",
        Color::class => "getColors",
        PsuConnector::class => "getPsuConnectors"
    ];
}