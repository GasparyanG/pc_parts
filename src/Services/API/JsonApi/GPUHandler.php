<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\GpuImage;
use App\Database\Entities\GpuPartNumber;
use App\Database\Entities\GpuPrice;
use App\Database\Entities\VideoCard;

class GPUHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = VideoCard::class;

    /**
     * {@inheritDoc}
     */
    protected static $relationshipProperties = [
        GpuImage::class => "getGpuImages",
        GpuPrice::class => "getGpuPrices",
        GpuPartNumber::class => "getPartNumbers"
    ];

    public function included(?string $relToInclude, int $id): array
    {
        // TODO: Implement included() method.
        return [];
    }
}