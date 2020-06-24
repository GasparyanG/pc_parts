<?php


namespace App\Services\Crawling\RetailerSpecificData\AbstractFactories;


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
}