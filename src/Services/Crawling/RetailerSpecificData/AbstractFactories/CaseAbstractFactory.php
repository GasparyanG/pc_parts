<?php


namespace App\Services\Crawling\RetailerSpecificData\AbstractFactories;


use App\Database\Entities\PcCase;

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

    /**
     * {@inheritDoc}
     */
    protected static $imageScraperName = PcCase::class;
}