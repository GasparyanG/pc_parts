<?php


namespace App\Services\Crawling\RetailerSpecificData\PersistingImplementers;


use App\Database\Entities\Cooler;

class CoolerPricePersistingImplementer extends AbstractPersistingImplementer
{
    /**
     * {@inheritDoc}
     */
    protected static $partPriceEntity = "App\Database\Entities\CoolerPrice";

    protected function setPart($partPriceEntity): void
    {
        $cooler = $this->em->getRepository(Cooler::class)
            ->find($this->crawledData[self::ENTITY_ID]);
        $partPriceEntity->setCooler($cooler);
    }
}