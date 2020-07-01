<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\MemoryImage;

class MemoryImageHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = MemoryImage::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}