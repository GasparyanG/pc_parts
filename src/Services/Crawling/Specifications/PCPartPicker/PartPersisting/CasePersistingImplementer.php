<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\PartPersisting;


use App\Database\Connection;
use App\Database\Entities\CaseBay;
use App\Database\Entities\CaseDimension;
use App\Database\Entities\CaseGpuLengthType;
use App\Database\Entities\CasePartNumber;
use App\Database\Entities\CaseType;
use App\Database\Entities\Color;
use App\Database\Entities\ExpansionSlot;
use App\Database\Entities\Manufacturer;
use App\Database\Entities\MoboFormFactor;
use App\Database\Entities\PcCase as PcCaseEntity;
use App\Database\Entities\SidePanelWindowType;
use App\Database\Entities\Usb;
use App\Services\Crawling\Specifications\PCPartPicker\Parts\PcCase;
use Doctrine\ORM\EntityManager;

class CasePersistingImplementer
{
    /**
     * @var PcCase
     */
    private $caseScrapedDataHolder;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(PcCase $case)
    {
        $this->caseScrapedDataHolder = $case;
        $this->em = Connection::getEntityManager();
    }

    public function insert(): void
    {
        $manufacturer = $this->manufacturer();
        $caseType = $this->caseType();
        $sidePanelWindowType = $this->sidePanelWindowType();
        $caseDimension = $this->caseDimension();

        $pcCase = new PcCaseEntity();
        $manufacturer->addPcCase($pcCase);

        if ($caseType)
            $caseType->addPcCase($pcCase);

        if ($sidePanelWindowType)
            $sidePanelWindowType->addPcCase($pcCase);

        if ($caseDimension)
            $caseDimension->addPcCase($pcCase);

        $pcCase->setName($this->caseScrapedDataHolder->getName());
        $pcCase->setUrl($this->caseScrapedDataHolder->getUrl());
        $pcCase->setPowerSupply($this->caseScrapedDataHolder->getPowerSupply());
        $pcCase->setPowerSupplyShroud($this->caseScrapedDataHolder->getPowerSupplyShroud());
        $pcCase->setVolume($this->caseScrapedDataHolder->getVolume());

        $this->em->persist($pcCase);
        $this->em->flush();

        $this->usbs($pcCase);
        $this->formFactors($pcCase);
        $this->expansionSlots($pcCase);
        $this->caseGpuLengthTypes($pcCase);
        $this->colors($pcCase);
        $this->casePartNumbers($pcCase);
        $this->bays($pcCase);

        $this->em->flush();
    }

    private function manufacturer(): Manufacturer
    {
        $manufacturer = $this->em->getRepository(Manufacturer::class)->findOneBy(
            [
                Manufacturer::NAME => $this->caseScrapedDataHolder->getManufacturer()
            ]
        );

        if (!$manufacturer) {
            $manufacturer = new Manufacturer();
            $manufacturer->setName($this->caseScrapedDataHolder->getManufacturer());

            // TODO: try to rely on UoW regarding insertion of this entity through CoolerEntity (1)
            $this->em->persist($manufacturer);
            $this->em->flush();
        }

        return $manufacturer;
    }

    private function caseType(): ?CaseType
    {
        if (!$this->caseScrapedDataHolder->getCaseType()) return null;

        $caseType = $this->em->getRepository(CaseType::class)->findOneBy(
            [
                CaseType::TYPE => $this->caseScrapedDataHolder->getCaseType()
            ]
        );

        if (!$caseType) {
            $caseType = new CaseType();
            $caseType->setType($this->caseScrapedDataHolder->getCaseType());

            // TODO: try to rely on UoW regarding insertion of this entity through CoolerEntity (1)
            $this->em->persist($caseType);
            $this->em->flush();
        }

        return $caseType;
    }

    private function sidePanelWindowType(): ?SidePanelWindowType
    {
        if (!$this->caseScrapedDataHolder->getSidePanelWindowType()) return null;

        $sidePanelWindowType = $this->em->getRepository(SidePanelWindowType::class)->findOneBy(
            [
                SidePanelWindowType::TYPE => $this->caseScrapedDataHolder->getSidePanelWindowType()
            ]
        );

        if (!$sidePanelWindowType) {
            $sidePanelWindowType = new SidePanelWindowType();
            $sidePanelWindowType->setType($this->caseScrapedDataHolder->getSidePanelWindowType());

            // TODO: try to rely on UoW regarding insertion of this entity through CoolerEntity (1)
            $this->em->persist($sidePanelWindowType);
            $this->em->flush();
        }

        return $sidePanelWindowType;
    }

    private function caseDimension(): ?CaseDimension
    {
        if (!$this->caseScrapedDataHolder->getCaseDimension()) return null;

        $caseDimensions = $this->caseScrapedDataHolder->getCaseDimension();
        $caseDimensionEntity = $this->em->getRepository(CaseDimension::class)->findOneBy(
            [
                CaseDimension::LENGTH => $caseDimensions[PcCase::LENGTH],
                CaseDimension::WIDTH => $caseDimensions[PcCase::WIDTH],
                CaseDimension::HEIGHT => $caseDimensions[PcCase::HEIGHT]
            ]
        );

        if (!$caseDimensionEntity) {
            $caseDimensionEntity = new CaseDimension();
            $caseDimensionEntity->setLength($caseDimensions[PcCase::LENGTH]);
            $caseDimensionEntity->setWidth($caseDimensions[PcCase::WIDTH]);
            $caseDimensionEntity->setHeight($caseDimensions[PcCase::HEIGHT]);

            // TODO: try to rely on UoW regarding insertion of this entity through CoolerEntity (1)
            $this->em->persist($caseDimensionEntity);
            $this->em->flush();
        }

        return $caseDimensionEntity;
    }

    private function usbs(PcCaseEntity& $pcCase): void
    {
        if (!$this->caseScrapedDataHolder->getUsbs()) return;

        foreach ($this->caseScrapedDataHolder->getUsbs() as $usbInfo) {
            $usb = $this->em->getRepository(Usb::class)->findOneBy(
                [
                    Usb::TYPE => $usbInfo[PcCase::TYPE] ?? null,
                    Usb::VERSION => $usbInfo[PcCase::VERSION] ?? null,
                    Usb::GENERATION => $usbInfo[PcCase::GENERATION] ?? null
                ]
            );

            if (!$usb) {
                $usb = new Usb();
                $usb->setType($usbInfo[PcCase::TYPE]);
                $usb->setVersion($usbInfo[PcCase::VERSION]);
                $usb->setGeneration($usbInfo[PcCase::GENERATION]);

                $this->em->persist($usb);
                $this->em->flush();
            }

            $pcCase->addUsb($usb);
        }
    }

    private function formFactors(PcCaseEntity& $pcCase): void
    {
        if (!$this->caseScrapedDataHolder->getFormFactors()) return;

        foreach ($this->caseScrapedDataHolder->getFormFactors() as $ffName) {
            $moboFormFactor = $this->em->getRepository(MoboFormFactor::class)->findOneBy(
                [
                    MoboFormFactor::TYPE => $ffName
                ]
            );

            if (!$moboFormFactor) {
                $moboFormFactor = new MoboFormFactor();
                $moboFormFactor->setType($ffName);

                // TODO: try to rely on UoW regarding insertion of this entity through CoolerEntity (1)
                $this->em->persist($moboFormFactor);
                $this->em->flush();
            }

            $pcCase->addFormFactor($moboFormFactor);
        }
    }

    private function expansionSlots(PcCaseEntity& $pcCase): void
    {
        if (!$this->caseScrapedDataHolder->getExpansionSlots()) return;

        foreach ($this->caseScrapedDataHolder->getExpansionSlots() as $key => $amount) {
            $expansionSlot = $this->em->getRepository(ExpansionSlot::class)->findOneBy(
                [
                    ExpansionSlot::TYPE => $key,
                    ExpansionSlot::AMOUNT => $amount
                ]
            );

            if (!$expansionSlot) {
                $expansionSlot = new ExpansionSlot();
                $expansionSlot->setType($key);
                $expansionSlot->setAmount($amount);

                $this->em->persist($expansionSlot);
                $this->em->flush();
            }

            $pcCase->addExpansionSlot($expansionSlot);
        }
    }

    private function caseGpuLengthTypes(PcCaseEntity& $pcCase): void
    {
        if (!$this->caseScrapedDataHolder->getCaseGpuLengthTypes()) return;

        foreach ($this->caseScrapedDataHolder->getCaseGpuLengthTypes() as $gpuLengthInfo) {
            $gpuLengthType = $this->em->getRepository(CaseGpuLengthType::class)->findOneBy(
                [
                    CaseGpuLengthType::CAGE => $gpuLengthInfo[PcCase::CAGE],
                    CaseGpuLengthType::LENGTH => $gpuLengthInfo[PcCase::SIZE],
                    CaseGpuLengthType::CASE => $pcCase
                ]
            );

            if (!$gpuLengthType) {
                $gpuLengthType = new CaseGpuLengthType();
                $gpuLengthType->setLength($gpuLengthInfo[PcCase::SIZE]);
                $gpuLengthType->setCage($gpuLengthInfo[PcCase::CAGE]);
                $gpuLengthType->setCase($pcCase);

                $this->em->persist($gpuLengthType);
                $this->em->flush();
            }

            $pcCase->addCaseGpuLengthTypes($gpuLengthType);
        }
    }

    private function casePartNumbers(PcCaseEntity& $pcCase): void
    {
        // At this moment cooler will already have id
        foreach ($this->caseScrapedDataHolder->getCasePartNumbers() as $partNumber) {
            $casePartNumber = $this->em->getRepository(CasePartNumber::class)->findOneBy(
                [
                    CasePartNumber::PART_NUMBER => $partNumber,
                    CasePartNumber::CASE => $pcCase
                ]
            );

            if (!$casePartNumber) {
                $casePartNumber = new CasePartNumber();
                $casePartNumber->setCase($pcCase);
                $casePartNumber->setPartNumber($partNumber);

                $this->em->persist($casePartNumber);
                $this->em->flush();
            }
        }
    }

    private function colors(PcCaseEntity& $pcCase): void
    {
        foreach ($this->caseScrapedDataHolder->getColors() as $color) {
            // getting color
            $colorEntity = $this->em->getRepository(Color::class)->findOneBy(
                [
                    Color::NAME => $color
                ]
            );

            if (!$colorEntity) {
                $colorEntity = new Color();
                $colorEntity->setName($color);

                // TODO: (1)
                $this->em->persist($colorEntity);
                $this->em->flush();
            }

            $pcCase->addColor($colorEntity);
        }
    }

    private function bays(PcCaseEntity& $pcCase): void
    {
        if (!$this->caseScrapedDataHolder->getBays()) return;

        foreach ($this->caseScrapedDataHolder->getBays() as $bayInfo) {
            $bay = $this->em->getRepository(CaseBay::class)->findOneBy(
                [
                    CaseBay::TYPE => $bayInfo[0],
                    CaseBay::SIZE => $bayInfo[1],
                    CaseBay::AMOUNT => $bayInfo[2]
                ]
            );

            if (!$bay) {
                $bay = new CaseBay();
                $bay->setType($bayInfo[0]);
                $bay->setSize($bayInfo[1]);
                $bay->setAmount($bayInfo[2]);

                $this->em->persist($bay);
                $this->em->flush();
            }

            $pcCase->addBay($bay);
        }
    }
}