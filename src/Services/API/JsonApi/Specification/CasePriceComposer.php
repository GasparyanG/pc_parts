<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\CasePrice;

class CasePriceComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CasePrice::class;
}