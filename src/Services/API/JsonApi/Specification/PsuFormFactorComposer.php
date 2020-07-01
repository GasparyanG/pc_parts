<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\PsuFormFactor;

class PsuFormFactorComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = PsuFormFactor::class;
}