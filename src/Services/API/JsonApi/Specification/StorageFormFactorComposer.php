<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\StorageFormFactor;

class StorageFormFactorComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = StorageFormFactor::class;
}