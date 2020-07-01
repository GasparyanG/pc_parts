<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\StorageType;

class StorageTypeHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = StorageType::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}