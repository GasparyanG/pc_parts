<?php


namespace App\Services\Crawling\RetailerSpecificData\Retailers;


use App\Database\Connection;
use Doctrine\ORM\EntityManager;
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

    /**
     * @var int
     */
    protected static $delay = 0;

    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct()
    {
        $this->client = new Client();
        $this->em = Connection::getEntityManager();
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

    public static function tofloat($num): float
    {
        $dotPos = strrpos($num, '.');
        $commaPos = strrpos($num, ',');
        $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
            ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);

        if (!$sep) {
            return floatval(preg_replace("/[^0-9]/", "", $num));
        }

        return floatval(
            preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
            preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)))
        );
    }


abstract public function crawl(string $searchTerm, int $entityId): void;
}