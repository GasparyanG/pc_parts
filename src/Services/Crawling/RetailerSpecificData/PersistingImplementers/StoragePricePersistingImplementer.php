<?php


namespace App\Services\Crawling\RetailerSpecificData\PersistingImplementers;


use App\Database\Entities\Storage;

class StoragePricePersistingImplementer extends AbstractPersistingImplementer
{
    /**
     * {@inheritDoc}
     */
    protected static $partPriceEntity = "App\Database\Entities\StoragePrice";

    protected function setPart($partPriceEntity): void
    {
        $storage = $this->em->getRepository(Storage::class)
            ->find($this->crawledData[self::ENTITY_ID]);
        $partPriceEntity->setStorage($storage);
    }
}