<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\CpuPartNumber;

class CpuPartNumberComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CpuPartNumber::class;
}