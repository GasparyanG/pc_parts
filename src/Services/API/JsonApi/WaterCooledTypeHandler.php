<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\WaterCooledType;

class WaterCooledTypeHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = WaterCooledType::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}