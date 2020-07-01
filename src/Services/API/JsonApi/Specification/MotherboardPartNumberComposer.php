<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\MotherboardPartNumber;

class MotherboardPartNumberComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = MotherboardPartNumber::class;
}