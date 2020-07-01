<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\LTwoCache;

class LTwoCacheComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = LTwoCache::class;
}