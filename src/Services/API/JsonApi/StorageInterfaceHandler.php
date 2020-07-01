<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\StorageInterface;

class StorageInterfaceHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = StorageInterface::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}