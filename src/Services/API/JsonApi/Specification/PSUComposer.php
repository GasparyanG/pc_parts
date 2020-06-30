<?php


namespace App\Services\API\JsonApi\Specification;


use App\Database\Entities\PowerSupply;

class PSUComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    protected static $entityName = PowerSupply::class;
}