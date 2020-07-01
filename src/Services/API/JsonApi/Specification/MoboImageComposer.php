<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\MoboImage;

class MoboImageComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = MoboImage::class;
}