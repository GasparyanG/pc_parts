<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\PsuConnector;

class PsuConnectorHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = PsuConnector::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}