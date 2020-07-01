<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\GpuInterface;

class GpuInterfaceComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = GpuInterface::class;
}