<?php


namespace App\Services\Crawling\RetailerSpecificData\PersistingImplementers;


use App\Database\Entities\Motherboard;

class MoboPricePersistingImplementer extends AbstractPersistingImplementer
{
    /**
     * {@inheritDoc}
     */
    protected static $partPriceEntity = "App\Database\Entities\MoboPrice";

    protected function setPart($partPriceEntity): void
    {
        $mobo = $this->em->getRepository(Motherboard::class)
            ->find($this->crawledData[self::ENTITY_ID]);
        $partPriceEntity->setMobo($mobo);
    }
}