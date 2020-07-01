<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\GpuCoolingType;

class GpuCoolingTypeComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = GpuCoolingType::class;
}