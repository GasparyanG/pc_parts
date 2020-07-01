<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\StorageFormFactor;

class StorageFormFactorHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = StorageFormFactor::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}