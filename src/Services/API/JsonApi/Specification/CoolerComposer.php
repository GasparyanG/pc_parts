<?php


namespace App\Services\API\JsonApi\Specification;


use App\Database\Entities\Cooler;

class CoolerComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Cooler::class;
}