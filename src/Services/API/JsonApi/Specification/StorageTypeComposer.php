<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\StorageType;

class StorageTypeComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = StorageType::class;
}