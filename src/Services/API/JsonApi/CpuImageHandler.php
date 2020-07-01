<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\CpuImage;

class CpuImageHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CpuImage::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}