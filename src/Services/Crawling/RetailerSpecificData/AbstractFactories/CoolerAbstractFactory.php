<?php


namespace App\Services\Crawling\RetailerSpecificData\AbstractFactories;


class CoolerAbstractFactory extends AbstractFactory
{
    /**
     * {@inheritDoc}
     */
    protected $persistingImplementer = "App\Services\Crawling\RetailerSpecificData\PersistingImplementers\CoolerPricePersistingImplementer";

    /**
     * {@inheritDoc}
     */
    protected $entity = "App\Database\Entities\CoolerPartNumber";
}