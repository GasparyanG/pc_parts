<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\CoolerImage;

class CoolerImageHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CoolerImage::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}