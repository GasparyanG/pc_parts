<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\PowerSupply;
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
    protected static $relationshipProperties = [
        PsuImage::class => "getPsuImages",
        PsuPrice::class => "getPsuPrices",
        PsuPartNumber::class => "getPartNumbers"
    ];

    public function included(?string $relToInclude, int $id): array
    {
        // TODO: Implement included() method.
        return [];
    }
}