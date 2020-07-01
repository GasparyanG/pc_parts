<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\PsuImage;

class PsuImageComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = PsuImage::class;
}