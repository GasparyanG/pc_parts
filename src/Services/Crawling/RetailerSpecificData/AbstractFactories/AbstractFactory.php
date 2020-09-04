<?php


namespace App\Services\Crawling\RetailerSpecificData\AbstractFactories;


use App\Services\Crawling\RetailerSpecificData\PersistingImplementers\AbstractPersistingImplementer;
use App\Services\Crawling\Specifications\PCPartPicker\PartImageScraping\ImageAbstractScraper;
use App\Services\Crawling\Specifications\PCPartPicker\PartImageScraping\ImageScraperFactory;

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

    /**
     * @var string|null
     */
    protected static $imageScraperName;

    public function getPersistingImplementer(array $scrapedData): AbstractPersistingImplementer
    {
        return new $this->persistingImplementer($scrapedData);
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function getImageCrawler(): ?ImageAbstractScraper
    {
        return ImageScraperFactory::create(static::$imageScraperName);
    }
}