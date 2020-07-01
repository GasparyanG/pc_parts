<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\GpuPrice;

class GpuPriceHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = GpuPrice::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}