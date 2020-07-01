<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\CaseBay;

class CaseBayComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CaseBay::class;
}