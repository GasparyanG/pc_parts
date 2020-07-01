<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\CaseImage;

class CaseImageHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CaseImage::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}