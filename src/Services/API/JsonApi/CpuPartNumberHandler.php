<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\CpuPartNumber;

class CpuPartNumberHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CpuPartNumber::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}