<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\MoboMemorySpeedType;

class MoboMemorySpeedTypeHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = MoboMemorySpeedType::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}