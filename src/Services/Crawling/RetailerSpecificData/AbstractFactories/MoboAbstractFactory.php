<?php


namespace App\Services\Crawling\RetailerSpecificData\AbstractFactories;


use App\Database\Entities\Motherboard;

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

    /**
     * {@inheritDoc}
     */
    protected static $imageScraperName = Motherboard::class;
}