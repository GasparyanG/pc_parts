<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\MoboPrice;

class MoboPriceComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = MoboPrice::class;
}