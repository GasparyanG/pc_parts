<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\PsuPrice;

class PsuPriceHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = PsuPrice::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}