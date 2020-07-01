<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\CoolerPrice;

class CoolerPriceHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CoolerPrice::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}