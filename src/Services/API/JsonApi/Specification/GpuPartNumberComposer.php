<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\GpuPartNumber;

class GpuPartNumberComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = GpuPartNumber::class;
}