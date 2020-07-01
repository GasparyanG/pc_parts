<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\GpuImage;

class GpuImageComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = GpuImage::class;
}