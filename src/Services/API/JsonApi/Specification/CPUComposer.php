<?php


namespace App\Services\API\JsonApi\Specification;


use App\Database\Entities\Cpu;

class CPUComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    protected static $entityName = Cpu::class;
}