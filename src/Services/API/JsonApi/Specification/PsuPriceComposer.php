<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\PsuPrice;

class PsuPriceComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = PsuPrice::class;
}