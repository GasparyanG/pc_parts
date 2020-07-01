<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\CoolerPartNumber;

class CoolerPartNumberComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CoolerPartNumber::class;
}