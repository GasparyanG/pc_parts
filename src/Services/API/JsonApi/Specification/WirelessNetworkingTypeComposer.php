<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\WirelessNetworkingType;

class WirelessNetworkingTypeComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = WirelessNetworkingType::class;
}