<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\StorageImage;

class StorageImageHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = StorageImage::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}