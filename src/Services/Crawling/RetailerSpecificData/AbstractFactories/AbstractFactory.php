<?php


namespace App\Services\Crawling\RetailerSpecificData\AbstractFactories;


use App\Services\Crawling\RetailerSpecificData\PersistingImplementers\AbstractPersistingImplementer;

abstract class AbstractFactory
{
    /**
     * @var string|null
     */
    protected $persistingImplementer;

    /**
     * @var string|null
     */
    protected $entity;

    public function getPersistingImplementer(array $scrapedData): AbstractPersistingImplementer
    {
        return new $this->persistingImplementer($scrapedData);
    }

    public function getEntity()
    {
        return $this->entity;
    }
}