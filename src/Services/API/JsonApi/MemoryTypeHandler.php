<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\MemoryType;

class MemoryTypeHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = MemoryType::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}