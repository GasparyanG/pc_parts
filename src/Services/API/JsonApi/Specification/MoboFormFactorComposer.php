<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\MoboFormFactor;

class MoboFormFactorComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = MoboFormFactor::class;
}