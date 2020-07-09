<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\Manufacturer;
use App\Database\Entities\Storage;
use App\Database\Entities\StorageFormFactor;
use App\Database\Entities\StorageImage;
use App\Database\Entities\StorageInterface;
use App\Database\Entities\StoragePartNumber;
use App\Database\Entities\StoragePrice;
use App\Database\Entities\StorageType;

class StorageHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Storage::class;

    /**
     * {@inheritDoc}
     */
    public static $priceEntityName = StoragePrice::class;

    /**
     * {@inheritDoc}
     */
    public static $imageEntityName = StorageImage::class;

    /**
     * {@inheritDoc}
     */
    public static $assocName = "storage";

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [
        StorageImage::class => "getStorageImages",
        StoragePrice::class => "getStoragePrices",
        StoragePartNumber::class => "getPartNumbers",
        Manufacturer::class => "getManufacturer",
        StorageType::class => "getStorageType",
        StorageFormFactor::class => "getStorageFormFactor",
        StorageInterface::class => "getStorageInterface"
    ];
}