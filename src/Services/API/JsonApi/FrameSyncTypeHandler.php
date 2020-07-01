<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\FrameSyncType;

class FrameSyncTypeHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = FrameSyncType::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}