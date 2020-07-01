<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\LTwoCache;

class LTwoCacheHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = LTwoCache::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}