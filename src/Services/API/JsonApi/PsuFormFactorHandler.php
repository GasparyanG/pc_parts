<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\PsuFormFactor;

class PsuFormFactorHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = PsuFormFactor::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}