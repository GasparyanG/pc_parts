<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\StorageInterface;

class StorageInterfaceComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = StorageInterface::class;
}