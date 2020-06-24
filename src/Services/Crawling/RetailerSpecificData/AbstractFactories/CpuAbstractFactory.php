<?php


namespace App\Services\Crawling\RetailerSpecificData\AbstractFactories;


class CpuAbstractFactory extends AbstractFactory
{
    /**
     * {@inheritDoc}
     */
    protected $persistingImplementer = "App\Services\Crawling\RetailerSpecificData\PersistingImplementers\CpuPricePersistingImplementer";

    /**
     * {@inheritDoc}
     */
    protected $entity = "App\Database\Entities\CpuPartNumber";
}