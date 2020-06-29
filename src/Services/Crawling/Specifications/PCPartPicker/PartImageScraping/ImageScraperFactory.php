<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\PartImageScraping;

class ImageScraperFactory
{
    /**
     * @var ImageAbstractScraper[]
     */
    protected static $imageScrapers = [
        CaseImageScraper::class,
        PsuImageScraper::class,
        GpuImageScraper::class,
        CpuImageScraper::class,
        CoolerImageScraper::class,
        StorageImageScraper::class,
        MemoryImageScraper::class,
        MoboImageScraper::class
    ];

    public static function create(string $scraperName): ?ImageAbstractScraper
    {
        foreach (self::$imageScrapers as $imageScraper)
            if ((new $imageScraper())->isUsed($scraperName))
                return new $imageScraper;
        return null;
    }
}