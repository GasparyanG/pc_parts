<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\MDot2Type;

class MDot2TypeHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = MDot2Type::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}