<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\GpuInterface;

class GpuInterfaceHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = GpuInterface::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}