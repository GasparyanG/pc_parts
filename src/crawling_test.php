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

$scraper = new CaseScraper();
$scraper->crawl();