<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\CaseDimension;

class CaseDimensionComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CaseDimension::class;
}