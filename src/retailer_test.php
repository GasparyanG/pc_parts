<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Services\Crawling\RetailerSpecificData\Retailers\BAndH;

//$am = new BAndH();
//$am->crawl("ROG-STRIX-RTX2080TI-O11G", 1);

for ($i = 88; $i < 171; ++$i)
    echo $i . ',';

//var_dump($am->getCrawledData());