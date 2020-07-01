<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\CpuPrice;

class CpuPriceHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CpuPrice::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}