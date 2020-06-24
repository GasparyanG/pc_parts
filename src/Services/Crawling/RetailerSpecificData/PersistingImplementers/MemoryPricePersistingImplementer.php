<?php


namespace App\Services\Crawling\RetailerSpecificData\PersistingImplementers;


use App\Database\Entities\Memory;

class MemoryPricePersistingImplementer extends AbstractPersistingImplementer
{
    /**
     * {@inheritDoc}
     */
    protected static $partPriceEntity = "App\Database\Entities\MemoryPrice";

    protected function setPart($partPriceEntity): void
    {
        $memory = $this->em->getRepository(Memory::class)
            ->find($this->crawledData[self::ENTITY_ID]);
        $partPriceEntity->setMemory($memory);
    }
}