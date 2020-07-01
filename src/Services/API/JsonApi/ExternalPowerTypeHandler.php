<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\ExternalPowerType;

class ExternalPowerTypeHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = ExternalPowerType::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}