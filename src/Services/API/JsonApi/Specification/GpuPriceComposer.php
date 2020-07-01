<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\GpuPrice;

class GpuPriceComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = GpuPrice::class;
}