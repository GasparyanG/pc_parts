<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\FormFactor;

class FormFactorComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = FormFactor::class;
}