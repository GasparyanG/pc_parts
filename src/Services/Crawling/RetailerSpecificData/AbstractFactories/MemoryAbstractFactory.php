<?php


namespace App\Services\Crawling\RetailerSpecificData\AbstractFactories;


class MemoryAbstractFactory extends AbstractFactory
{
    /**
     * {@inheritDoc}
     */
    protected $persistingImplementer = "App\Services\Crawling\RetailerSpecificData\PersistingImplementers\MemoryPricePersistingImplementer";

    /**
     * {@inheritDoc}
     */
    protected $entity = "App\Database\Entities\MemoryPartNumber";
}