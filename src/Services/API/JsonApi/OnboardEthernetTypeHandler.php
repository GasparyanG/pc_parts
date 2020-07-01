<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\OnboardEthernetType;

class OnboardEthernetTypeHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = OnboardEthernetType::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}