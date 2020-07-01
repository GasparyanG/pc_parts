<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\CpuPrice;

class CpuPriceComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CpuPrice::class;
}