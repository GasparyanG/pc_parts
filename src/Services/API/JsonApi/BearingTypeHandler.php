<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\BearingType;

class BearingTypeHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = BearingType::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}