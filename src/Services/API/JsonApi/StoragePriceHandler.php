<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\StoragePrice;

class StoragePriceHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = StoragePrice::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}