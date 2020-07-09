<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\Color;
use App\Database\Entities\EfficiencyRating;
use App\Database\Entities\Manufacturer;
use App\Database\Entities\PowerSupply;
use App\Database\Entities\PsuConnector;
use App\Database\Entities\PsuFormFactor;
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
    public static $priceEntityName = PsuPrice::class;

    /**
     * {@inheritDoc}
     */
    public static $imageEntityName = PsuImage::class;

    /**
     * {@inheritDoc}
     */
    public static $assocName = "psu";

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [
        PsuImage::class => "getPsuImages",
        PsuPrice::class => "getPsuPrices",
        PsuPartNumber::class => "getPartNumbers",
        Color::class => "getColors",
        PsuConnector::class => "getPsuConnectors",
        Manufacturer::class => "getManufacturer",
        PsuFormFactor::class => "getPsuFormFactor",
        EfficiencyRating::class => "getEfficiencyRating"
    ];
}