<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\CpuSocket;

class CpuSocketComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CpuSocket::class;
}