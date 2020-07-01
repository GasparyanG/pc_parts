<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\SliCrossfireType;

class SliCrossfireTypeComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = SliCrossfireType::class;
}