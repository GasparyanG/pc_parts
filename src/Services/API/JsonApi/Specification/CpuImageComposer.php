<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\CpuImage;

class CpuImageComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CpuImage::class;
}