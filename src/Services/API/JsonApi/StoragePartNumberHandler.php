<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\StoragePartNumber;

class StoragePartNumberHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = StoragePartNumber::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}