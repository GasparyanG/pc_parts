<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\Microarchitecture;

class MicroarchitectureHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Microarchitecture::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}