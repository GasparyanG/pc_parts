<?php

require_once __DIR__ . "/../../../../vendor/autoload.php";

use App\Services\Crawling\RetailerSpecificData\Retailers\BAndH;
use App\Services\Crawling\RetailerSpecificData\Retailers\Walmart;

$ret = new BAndH();
$ret->crawl("B450 AORUS M", 7);
var_dump($ret->getCrawledData());