<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\ExternalPowerType;

class ExternalPowerTypeComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = ExternalPowerType::class;
}