<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\Storage;
use App\Database\Entities\StorageImage;
use App\Database\Entities\StoragePartNumber;
use App\Database\Entities\StoragePrice;

class StorageHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Storage::class;

    /**
     * {@inheritDoc}
     */
    protected static $relationshipProperties = [
        StorageImage::class => "getStorageImages",
        StoragePrice::class => "getStoragePrices",
        StoragePartNumber::class => "getPartNumbers"
    ];

    public function included(?string $relToInclude, int $id): array
    {
        // TODO: Implement included() method.
        return [];
    }
}