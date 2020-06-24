<?php


namespace App\Services\Crawling\RetailerSpecificData\PersistingImplementers;


use App\Database\Entities\PowerSupply;

class PsuPricePersistingImplementer extends AbstractPersistingImplementer
{
    /**
     * {@inheritDoc}
     */
    protected static $partPriceEntity = "App\Database\Entities\PsuPrice";

    protected function setPart($partPriceEntity): void
    {
        $psu = $this->em->getRepository(PowerSupply::class)
            ->find($this->crawledData[self::ENTITY_ID]);
        $partPriceEntity->setPsu($psu);
    }
}