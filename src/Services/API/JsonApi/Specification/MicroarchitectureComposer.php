<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\Microarchitecture;

class MicroarchitectureComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Microarchitecture::class;
}