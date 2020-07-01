<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\MemoryPrice;

class MemoryPriceHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = MemoryPrice::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}