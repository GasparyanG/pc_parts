<?php


namespace App\Services\Crawling\RetailerSpecificData\PersistingImplementers;


use App\Database\Entities\VideoCard;

class GpuPricePersistingImplementer extends AbstractPersistingImplementer
{
    /**
     * {@inheritDoc}
     */
    protected static $partPriceEntity = "App\Database\Entities\GpuPrice";

    protected function setPart($partPriceEntity): void
    {
        $gpu = $this->em->getRepository(VideoCard::class)
            ->find($this->crawledData[self::ENTITY_ID]);
        $partPriceEntity->setGpu($gpu);
    }
}
