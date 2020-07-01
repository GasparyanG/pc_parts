<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\MoboMemorySpeedType;

class MoboMemorySpeedTypeComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = MoboMemorySpeedType::class;
}