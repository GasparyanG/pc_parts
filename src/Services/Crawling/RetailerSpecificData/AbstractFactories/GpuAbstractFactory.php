<?php


namespace App\Services\Crawling\RetailerSpecificData\AbstractFactories;


use App\Database\Entities\VideoCard;

class GpuAbstractFactory extends AbstractFactory
{
    /**
     * {@inheritDoc}
     */
    protected $persistingImplementer = "App\Services\Crawling\RetailerSpecificData\PersistingImplementers\GpuPricePersistingImplementer";

    /**
     * {@inheritDoc}
     */
    protected $entity = "App\Database\Entities\GpuPartNumber";

    /**
     * {@inheritDoc}
     */
    protected static $imageScraperName = VideoCard::class;
}