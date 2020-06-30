<?php


namespace App\Services\API\JsonApi\Specification;


use App\Database\Repositories\CpuRepository;

class CPUComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    protected static $tableName = CpuRepository::TABLE_NAME;
}