<?php


namespace App\Services\API\JsonApi\Specification;


use App\Database\Entities\Cooler;

class CoolerComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Cooler::class;

    /**
     * {@inheritDoc}
     */
    protected static $includedParams = [
        "cooler_images",
        "cooler_prices",
        "cooler_part_numbers",
        "cpu_sockets",
        "colors",
        "manufacturers",
        "bearing_types",
        "water_cooled_types"
    ];
}