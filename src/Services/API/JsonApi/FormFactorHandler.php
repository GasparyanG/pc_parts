<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\FormFactor;

class FormFactorHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = FormFactor::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}