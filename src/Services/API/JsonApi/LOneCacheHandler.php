<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\LOneCache;

class LOneCacheHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = LOneCache::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}