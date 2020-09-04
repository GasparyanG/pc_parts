<?php


namespace App\Services\Crawling\RetailerSpecificData\PersistingImplementers;


use App\Database\Connection;
use App\Database\Entities\Retailer;
use Doctrine\ORM\EntityManager;

abstract class AbstractPersistingImplementer
{
    const PRICE = "price";
    const ENTITY_ID = "entity_id";
    const RETAILER_ID = "retailer_id";
    const URL = "url";
    const IMAGES = "images";

    /**
     * @var string|null
     */
    protected static $partPriceEntity;

    /**
     * @var array
     */
    protected $crawledData;

    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct(array $crawledData)
    {
        $this->crawledData = $crawledData;
        $this->em = Connection::getEntityManager();
    }

    public function persist(): void
    {
        $price = $this->crawledData[self::PRICE] ?? null;
        $url = $this->crawledData[self::URL] ?? null;
        $retailer_id = $this->crawledData[self::RETAILER_ID] ?? null;
        $entity_id = $this->crawledData[self::ENTITY_ID] ?? null;

        if (!$price || !$retailer_id || !$entity_id) return;


        $partPriceEntity = new static::$partPriceEntity();

        // price
        $partPriceEntity->setPrice($price);

        // Retailer
        $retailer = $this->em->getRepository(Retailer::class)->find($retailer_id);
        $partPriceEntity->setRetailer($retailer);

        // Part
        $this->setPart($partPriceEntity);

        // url
        $partPriceEntity->setUrl($url);

        // date
        $partPriceEntity->setDate(time());

        $this->em->persist($partPriceEntity);
        $this->em->flush();
    }

    abstract protected function setPart($partPriceEntity): void;
}