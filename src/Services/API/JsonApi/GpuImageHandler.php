<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\GpuImage;

class GpuImageHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = GpuImage::class;

    /**
     * {@inheritDoc}
     */
    protected static $relationshipProperties = [];
}