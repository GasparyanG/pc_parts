<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\MemoryPartNumber;

class MemoryPartNumberHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = MemoryPartNumber::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}