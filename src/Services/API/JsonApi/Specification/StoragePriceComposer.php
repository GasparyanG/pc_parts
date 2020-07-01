<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\StoragePrice;

class StoragePriceComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = StoragePrice::class;
}