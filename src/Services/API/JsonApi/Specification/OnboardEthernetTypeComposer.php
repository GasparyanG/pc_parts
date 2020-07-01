<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\OnboardEthernetType;

class OnboardEthernetTypeComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = OnboardEthernetType::class;
}