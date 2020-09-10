<?php


namespace App\Services\API\JsonApi\Specification;


use App\Database\Entities\VideoCard;

class GPUComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    protected static $entityName = VideoCard::class;

    /**
     * {@inheritDoc}
     */
    protected static $includedParams = [
        "gpu_images",
        "gpu_part_numbers",
        "frame_sync_types",
        "external_power_types",
        "gpu_cooling_types",
        "gpu_ports",
        "colors",
        "manufacturers",
        "memory_types",
        "gpu_interfaces",
        "gpu_prices"
    ];
}