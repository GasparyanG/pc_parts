<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\MemoryType;

class MemoryTypeComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = MemoryType::class;
}