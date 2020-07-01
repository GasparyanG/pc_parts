<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\PsuImage;

class PsuImageHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = PsuImage::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}