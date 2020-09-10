<?php


namespace App\Services\API\JsonApi\Specification;


use App\Database\Entities\Storage as StorageEntity;

class StorageComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    protected static $entityName = StorageEntity::class;

    /**
     * {@inheritDoc}
     */
    protected static $includedParams = [
        "storage_images",
        "storage_part_numbers",
        "manufacturers",
        "storage_types",
        "storage_form_factors",
        "storage_interfaces",
        "storage_prices"
    ];
}