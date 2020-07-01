<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\GpuPartNumber;

class GpuPartNumberHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = GpuPartNumber::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}