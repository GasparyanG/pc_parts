<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\Color;

class ColorComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Color::class;
}