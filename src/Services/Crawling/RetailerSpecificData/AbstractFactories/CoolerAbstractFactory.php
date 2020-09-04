<?php


namespace App\Services\Crawling\RetailerSpecificData\AbstractFactories;


use App\Database\Entities\Cooler;

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

    /**
     * {@inheritDoc}
     */
    protected static $imageScraperName = Cooler::class;
}