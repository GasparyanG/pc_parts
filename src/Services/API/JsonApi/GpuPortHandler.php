<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\GpuPort;

class GpuPortHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = GpuPort::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}