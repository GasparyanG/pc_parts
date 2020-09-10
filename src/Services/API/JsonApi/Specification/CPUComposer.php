<?php


namespace App\Services\API\JsonApi\Specification;


use App\Database\Entities\Cpu;

class CPUComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    protected static $entityName = Cpu::class;

    /**
     * {@inheritDoc}
     */
    protected static $includedParams = [
        "cpu_images",
        "l_one_caches",
        "l_two_caches",
        "l_three_caches",
        "core_families",
        "integrated_graphics",
        "microarchitectures",
        "cpu_series",
        "cpu_sockets",
        "manufacturers",
        "cpu_part_numbers",
        "cpu_prices"
    ];
}