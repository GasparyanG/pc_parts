<?php


namespace App\Services\Crawling\RetailerSpecificData\PersistingImplementers;


use App\Database\Entities\PcCase;

class CasePricePersistingImplementer extends AbstractPersistingImplementer
{
    /**
     * {@inheritDoc}
     */
    protected static $partPriceEntity = "App\Database\Entities\CasePrice";

    protected function setPart($partPriceEntity): void
    {
        $case = $this->em->getRepository(PcCase::class)
            ->find($this->crawledData[self::ENTITY_ID]);
        $partPriceEntity->setCase($case);
    }
}
