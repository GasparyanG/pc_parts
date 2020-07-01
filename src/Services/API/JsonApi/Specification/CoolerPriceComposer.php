<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\CoolerPrice;

class CoolerPriceComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CoolerPrice::class;
}