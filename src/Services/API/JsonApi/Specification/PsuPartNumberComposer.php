<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\PsuPartNumber;

class PsuPartNumberComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = PsuPartNumber::class;
}