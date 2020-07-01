<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\MemoryPartNumber;

class MemoryPartNumberComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = MemoryPartNumber::class;
}