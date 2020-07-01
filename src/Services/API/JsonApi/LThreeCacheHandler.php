<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\LThreeCache;

class LThreeCacheHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = LThreeCache::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}