<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\FrameSyncType;

class FrameSyncTypeComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = FrameSyncType::class;
}