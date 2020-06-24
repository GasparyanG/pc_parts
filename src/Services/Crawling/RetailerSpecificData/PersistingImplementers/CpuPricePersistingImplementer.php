<?php


namespace App\Services\Crawling\RetailerSpecificData\PersistingImplementers;


use App\Database\Entities\Cpu;

class CpuPricePersistingImplementer extends AbstractPersistingImplementer
{
    /**
     * {@inheritDoc}
     */
    protected static $partPriceEntity = "App\Database\Entities\CpuPrice";

    protected function setPart($partPriceEntity): void
    {
        $cpu = $this->em->getRepository(Cpu::class)
            ->find($this->crawledData[self::ENTITY_ID]);
        $partPriceEntity->setCpu($cpu);
    }
}