<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\StoragePartNumber;

class StoragePartNumberComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = StoragePartNumber::class;
}