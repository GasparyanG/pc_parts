<?php


namespace App\Services\Crawling\RetailerSpecificData\AbstractFactories;


class MoboAbstractFactory extends AbstractFactory
{
    /**
     * {@inheritDoc}
     */
    protected $persistingImplementer = "App\Services\Crawling\RetailerSpecificData\PersistingImplementers\MoboPricePersistingImplementer";

    /**
     * {@inheritDoc}
     */
    protected $entity = "App\Database\Entities\MotherboardPartNumber";
}