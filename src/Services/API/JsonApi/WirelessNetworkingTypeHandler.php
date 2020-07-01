<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\WirelessNetworkingType;

class WirelessNetworkingTypeHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = WirelessNetworkingType::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}