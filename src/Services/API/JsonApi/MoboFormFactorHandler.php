<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\MoboFormFactor;

class MoboFormFactorHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = MoboFormFactor::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}