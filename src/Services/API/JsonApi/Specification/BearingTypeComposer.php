<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\BearingType;

class BearingTypeComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = BearingType::class;
}