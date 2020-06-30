<?php


namespace App\Services\API\JsonApi\Specification;


use App\Database\Entities\Memory;

class MemoryComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    protected static $entityName = Memory::class;
}