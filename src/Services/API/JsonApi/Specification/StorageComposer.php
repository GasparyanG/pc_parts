<?php


namespace App\Services\API\JsonApi\Specification;


use App\Database\Entities\Storage as StorageEntity;

class StorageComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    protected static $entityName = StorageEntity::class;
}