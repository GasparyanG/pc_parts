<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\PsuConnector;

class PsuConnectorComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = PsuConnector::class;
}