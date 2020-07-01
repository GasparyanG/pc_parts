<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\MoboImage;

class MoboImageHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = MoboImage::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}