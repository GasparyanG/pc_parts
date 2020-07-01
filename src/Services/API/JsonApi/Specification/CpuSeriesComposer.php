<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\CpuSeries;

class CpuSeriesComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CpuSeries::class;
}