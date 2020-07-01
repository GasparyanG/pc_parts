<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\Color;
use App\Database\Entities\Memory;
use App\Database\Entities\MemoryImage;
use App\Database\Entities\MemoryPartNumber;
use App\Database\Entities\MemoryPrice;

class MemoryHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Memory::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [
        MemoryImage::class => "getMemoryImages",
        MemoryPrice::class => "getMemoryPrices",
        MemoryPartNumber::class => "getPartNumbers",
        Color::class => "getColors"
    ];
}