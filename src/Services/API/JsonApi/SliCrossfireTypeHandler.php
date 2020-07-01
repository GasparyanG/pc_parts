<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\SliCrossfireType;

class SliCrossfireTypeHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = SliCrossfireType::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}