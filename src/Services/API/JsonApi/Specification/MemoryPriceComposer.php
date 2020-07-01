<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\MemoryPrice;

class MemoryPriceComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = MemoryPrice::class;
}