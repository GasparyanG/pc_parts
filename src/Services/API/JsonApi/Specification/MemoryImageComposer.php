<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\MemoryImage;

class MemoryImageComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = MemoryImage::class;
}