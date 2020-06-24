<?php


namespace App\Services\Crawling\RetailerSpecificData\AbstractFactories;


class CaseAbstractFactory extends AbstractFactory
{
    /**
     * {@inheritDoc}
     */
    protected $persistingImplementer = "App\Services\Crawling\RetailerSpecificData\PersistingImplementers\CasePricePersistingImplementer";

    /**
     * {@inheritDoc}
     */
    protected $entity = "App\Database\Entities\CasePartNumber";
}