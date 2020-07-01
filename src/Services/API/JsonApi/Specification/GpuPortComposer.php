<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\GpuPort;

class GpuPortComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = GpuPort::class;
}