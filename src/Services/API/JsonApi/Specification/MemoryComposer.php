<?php


namespace App\Services\API\JsonApi\Specification;


use App\Database\Entities\Memory;

class MemoryComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    protected static $entityName = Memory::class;

    /**
     * {@inheritDoc}
     */
    protected static $includedParams = [
        "memory_images",
        "memory_part_numbers",
        "colors",
        "manufacturers",
        "form_factors",
        "modules",
        "timings",
        "ecc_registers",
        "memory_prices"
    ];
}