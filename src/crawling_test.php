<?php
require_once __DIR__ . "/../vendor/autoload.php";

use App\Services\Crawling\Specifications\PCPartPicker\PartScraping\
{
    CoolerScraper,
    MemoryScraper,
    CPUScraper,
    StorageScraper,
    PSUScraper,
    MOBOScraping,
    GPUScraper,
    CaseScraper
};

$scrapers = [
    CoolerScraper::class,
    MemoryScraper::class,
    CPUScraper::class,
    StorageScraper::class,
    PSUScraper::class,
    MOBOScraping::class,
    GPUScraper::class,
    CaseScraper::class
];

foreach ($scrapers as $scraper)
    (new $scraper)->crawl();