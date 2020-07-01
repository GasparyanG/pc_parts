<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\LOneCache;

class LOneCacheComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = LOneCache::class;
}