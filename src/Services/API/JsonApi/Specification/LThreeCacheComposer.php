<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\LThreeCache;

class LThreeCacheComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = LThreeCache::class;
}