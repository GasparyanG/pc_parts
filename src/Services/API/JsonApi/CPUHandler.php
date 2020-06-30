<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\Cpu;
use App\Database\Entities\CpuImage;
use App\Database\Entities\CpuPartNumber;
use App\Database\Entities\CpuPrice;

class CPUHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Cpu::class;

    /**
     * {@inheritDoc}
     */
    protected static $relationshipProperties = [
        CpuImage::class => "getCpuImages",
        CpuPrice::class => "getCpuPrices",
        CpuPartNumber::class => "getPartNumbers"
    ];

    public function included(?string $relToInclude, int $id): array
    {
        // TODO: Implement included() method.
        return [];
    }
}