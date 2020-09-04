<?php


namespace App\Services\Crawling\RetailerSpecificData\AbstractFactories;


use App\Database\Entities\PowerSupply;

class PsuAbstractFactory extends AbstractFactory
{
    /**
     * {@inheritDoc}
     */
    protected $persistingImplementer = "App\Services\Crawling\RetailerSpecificData\PersistingImplementers\PsuPricePersistingImplementer";

    /**
     * {@inheritDoc}
     */
    protected $entity = "App\Database\Entities\PsuPartNumber";

    /**
     * {@inheritDoc}
     */
    protected static $imageScraperName = PowerSupply::class;
}