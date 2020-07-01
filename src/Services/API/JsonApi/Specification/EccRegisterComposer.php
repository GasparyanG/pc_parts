<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\EccRegister;

class EccRegisterComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = EccRegister::class;
}