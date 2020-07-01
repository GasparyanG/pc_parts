<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\StorageImage;

class StorageImageComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = StorageImage::class;
}