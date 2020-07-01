<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\PsuPartNumber;

class PsuPartNumberHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = PsuPartNumber::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}