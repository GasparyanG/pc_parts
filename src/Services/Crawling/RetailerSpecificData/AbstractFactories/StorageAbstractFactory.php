<?php


namespace App\Services\Crawling\RetailerSpecificData\AbstractFactories;


class StorageAbstractFactory extends AbstractFactory
{
    /**
     * {@inheritDoc}
     */
    protected $persistingImplementer = "App\Services\Crawling\RetailerSpecificData\PersistingImplementers\StoragePricePersistingImplementer";

    /**
     * {@inheritDoc}
     */
    protected $entity = "App\Database\Entities\StoragePartNumber";
}