<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\CpuSocket;

class CpuSocketHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CpuSocket::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}