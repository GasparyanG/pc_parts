<?php

require_once __DIR__ . "/../../../../vendor/autoload.php";

use App\Services\Crawling\RetailerSpecificData\Retailers\BAndH;
use App\Services\Crawling\RetailerSpecificData\Retailers\Walmart;
use App\Services\Crawling\Specifications\PCPartPicker\PartImageScraping\GpuImageScraper;

$ret = new BAndH();
$ret->crawl("TUF-GTX1660S-O6G-GAMING", 23, new GpuImageScraper());
var_dump($ret->getCrawledData());