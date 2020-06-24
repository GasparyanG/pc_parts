<?php


namespace App\Services\Crawling\RetailerSpecificData\AbstractFactories;


class GpuAbstractFactory extends AbstractFactory
{
    /**
     * {@inheritDoc}
     */
    protected $persistingImplementer = "App\Services\Crawling\RetailerSpecificData\PersistingImplementers\GpuPricePersistingImplementer";

    /**
     * {@inheritDoc}
     */
    protected $entity = "App\Database\Entities\GpuPartNumber";
}