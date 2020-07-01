<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\GpuCoolingType;

class GpuCoolingTypeHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = GpuCoolingType::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}