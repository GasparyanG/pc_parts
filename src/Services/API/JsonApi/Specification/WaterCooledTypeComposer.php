<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\WaterCooledType;

class WaterCooledTypeComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = WaterCooledType::class;
}