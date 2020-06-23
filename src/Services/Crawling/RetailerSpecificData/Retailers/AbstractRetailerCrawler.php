<?php


namespace App\Services\Crawling\RetailerSpecificData\Retailers;


use GuzzleHttp\Client;

abstract class AbstractRetailerCrawler
{
    /**
     * Retailer's base url
     * @var null|string
     */
    protected static $baseUrl = null;

    /**
     * Items to crawl from collection page
     * @var int
     */
    public static $amountOfItems = 5;

    /**
     * Crawled data
     * @var array
     */
    protected $crawledData = [];

    /**
     * @var Client
     */
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @return array
     */
    public function getCrawledData(): array
    {
        return $this->crawledData;
    }

    /**
     * @param array $crawledData
     */
    public function setCrawledData(array $crawledData): void
    {
        $this->crawledData = $crawledData;
    }
}