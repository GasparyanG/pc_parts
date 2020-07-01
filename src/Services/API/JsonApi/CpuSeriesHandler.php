<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\CpuSeries;

class CpuSeriesHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CpuSeries::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [];
}