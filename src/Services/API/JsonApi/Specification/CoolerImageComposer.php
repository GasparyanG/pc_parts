<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\CoolerImage;

class CoolerImageComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CoolerImage::class;
}