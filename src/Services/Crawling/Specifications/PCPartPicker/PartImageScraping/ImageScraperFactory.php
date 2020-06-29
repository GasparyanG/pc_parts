<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\PartImageScraping;
use App\Database\Entities\
{
    Cooler,
    Cpu,
    Memory,
    Motherboard,
    PcCase,
    PowerSupply,
    Storage,
    VideoCard
};

class ImageScraperFactory
{
    /**
     * @var ImageAbstractScraper[]
     */
    protected static $imageScrapers = [
        PcCase::class,
        PowerSupply::class,
        VideoCard::class,
        Cpu::class,
        Cooler::class,
        Storage::class,
        Memory::class,
        Motherboard::class
    ];

    public static function create(string $scraperName): ?ImageAbstractScraper
    {
        foreach (self::$imageScrapers as $imageScraper)
            if ((new $imageScraper)->isUsed($scraperName))
                return new $imageScraper;
        return null;
    }
}