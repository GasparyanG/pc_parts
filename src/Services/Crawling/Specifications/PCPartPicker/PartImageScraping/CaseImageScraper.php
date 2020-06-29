<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\PartImageScraping;


use App\Database\Entities\CaseImage;
use App\Database\Entities\PcCase;

class CaseImageScraper extends ImageAbstractScraper
{
    /**
     * {@inheritDoc}
     */
    protected static $name = PcCase::class;

    /**
     * {@inheritDoc}
     */
    protected static $referer = "case/";

    public function persist(string $imageFileName, int $id): void
    {
        $case = $this->em->getRepository(PcCase::class)->find($id);
        if (!$case) return;

        $caseImage = new CaseImage();
        $caseImage->setFileName($imageFileName);
        $caseImage->setCase($case);

        $this->em->persist($caseImage);
        $this->em->flush();
    }
}