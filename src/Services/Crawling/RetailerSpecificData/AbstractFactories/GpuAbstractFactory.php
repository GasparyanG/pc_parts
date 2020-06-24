<?php


namespace App\Services\Crawling\RetailerSpecificData\AbstractFactories;


use App\Services\Crawling\RetailerSpecificData\PersistingImplementers\AbstractPersistingImplementer;

class GpuAbstractFactory
{
    /**
     * @var string
     */
    protected $persistingImplementer = "App\Services\Crawling\RetailerSpecificData\PersistingImplementers\GpuPricePersistingImplementer";
    protected $entity = "App\Database\Entities\GpuPartNumber";

    public function getPersistingImplementer(array $scrapedData): AbstractPersistingImplementer
    {
        return new $this->persistingImplementer($scrapedData);
    }

    public function getEntity()
    {
        return $this->entity;
    }
}