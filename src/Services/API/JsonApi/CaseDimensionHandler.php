<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\CaseDimension;

class CaseDimensionHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CaseDimension::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}