<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\PartPersisting;


use App\Database\Connection;
use App\Database\Entities\Color;
use App\Database\Entities\Connector;
use App\Database\Entities\EfficiencyRating;
use App\Database\Entities\Manufacturer;
use App\Database\Entities\PowerSupply;
use App\Database\Entities\PsuConnector;
use App\Database\Entities\PsuFormFactor;
use App\Database\Entities\PsuPartNumber;
use App\Services\Crawling\Specifications\PCPartPicker\Parts\PSU;
use Doctrine\ORM\EntityManager;

class PSUPersistingImplementer
{
    /**
     * @var PSU
     */
    private $psuScrapedDataHolder;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(PSU $psu)
    {
        $this->psuScrapedDataHolder = $psu;
        $this->em = Connection::getEntityManager();
    }

    public function insert(): void
    {
        $manufacturer = $this->manufacturer();
        $psuFormFactor = $this->formFactor();
        $efficiencyRating = $this->efficiencyRating();

        $psu = new PowerSupply();
        $manufacturer->addPowerSupply($psu);

        if ($psuFormFactor)
            $psuFormFactor->addPowerSupply($psu);

        if ($efficiencyRating)
            $efficiencyRating->addPowerSupply($psu);

        $psu->setName($this->psuScrapedDataHolder->getName());
        $psu->setUrl($this->psuScrapedDataHolder->getUrl());
        $psu->setWattage($this->psuScrapedDataHolder->getWattage());
        $psu->setLength($this->psuScrapedDataHolder->getLength());
        $psu->setFanless($this->psuScrapedDataHolder->getFanless());
        $psu->setModular($this->psuScrapedDataHolder->getModular());

        $this->em->persist($psu);
        $this->em->flush();

        // PSU Connectors, PSU Part Number, Colors
        $this->psuPartNumbers($psu);
        $this->colors($psu);
        $this->connectors($psu);

        $this->em->flush($psu);
    }

    private function manufacturer(): Manufacturer
    {
        $manufacturer = $this->em->getRepository(Manufacturer::class)->findOneBy(
            [
                Manufacturer::NAME => $this->psuScrapedDataHolder->getManufacturer()
            ]
        );

        if (!$manufacturer) {
            $manufacturer = new Manufacturer();
            $manufacturer->setName($this->psuScrapedDataHolder->getManufacturer());

            // TODO: try to rely on UoW regarding insertion of this entity through CoolerEntity (1)
            $this->em->persist($manufacturer);
            $this->em->flush();
        }

        return $manufacturer;
    }

    private function formFactor(): ?PsuFormFactor
    {
        if (!$this->psuScrapedDataHolder->getPsuFormFactor())
            return null;

        $formFactor = $this->em->getRepository(PsuFormFactor::class)->findOneBy(
            [
                PsuFormFactor::TYPE => $this->psuScrapedDataHolder->getPsuFormFactor()
            ]
        );

        if (!$formFactor) {
            $formFactor = new PsuFormFactor();
            $formFactor->setType($this->psuScrapedDataHolder->getPsuFormFactor());

            // TODO: try to rely on UoW regarding insertion of this entity through CoolerEntity (1)
            $this->em->persist($formFactor);
            $this->em->flush();
        }

        return $formFactor;
    }

    private function efficiencyRating(): ?EfficiencyRating
    {
        if (!$this->psuScrapedDataHolder->getEfficiencyRating())
            return null;

        $effRating = $this->em->getRepository(EfficiencyRating::class)->findOneBy(
            [
                EfficiencyRating::RATING => $this->psuScrapedDataHolder->getEfficiencyRating()
            ]
        );

        if (!$effRating) {
            $effRating = new EfficiencyRating();
            $effRating->setRating($this->psuScrapedDataHolder->getEfficiencyRating());

            // TODO: try to rely on UoW regarding insertion of this entity through CoolerEntity (1)
            $this->em->persist($effRating);
            $this->em->flush();
        }

        return $effRating;
    }

    private function psuPartNumbers(PowerSupply& $psu): void
    {
        // At this moment cooler will already have id
        foreach ($this->psuScrapedDataHolder->getPartNumbers() as $partNumber) {
            $psuPartNumber = $this->em->getRepository(PsuPartNumber::class)->findOneBy(
                [
                    PsuPartNumber::PART_NUMBER => $partNumber,
                    PsuPartNumber::POWER_SUPPLY => $psu
                ]
            );

            if (!$psuPartNumber) {
                $psuPartNumber = new PsuPartNumber();
                $psuPartNumber->setPowerSupply($psu);
                $psuPartNumber->setPartNumber($partNumber);

                $this->em->persist($psuPartNumber);
                $this->em->flush();
            }
        }
    }

    private function colors(PowerSupply& $psu): void
    {
        foreach ($this->psuScrapedDataHolder->getColors() as $color) {
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

            $psu->addColor($colorEntity);
        }
    }

    private function connectors(PowerSupply& $psu): void
    {
        foreach ($this->psuScrapedDataHolder->getPsuConnectors() as $connectorName => $amount) {
            $connector = $this->em->getRepository(Connector::class)->findOneBy(
                [
                    Connector::TYPE => $connectorName
                ]
            );

            if (!$connector) {
                $connector = new Connector();
                $connector->setType($connectorName);

                $this->em->persist($connector);
                $this->em->flush();
            }

            $psuConnector = $this->em->getRepository(PsuConnector::class)->findOneBy(
                [
                    PsuConnector::AMOUNT => $amount,
                    PsuConnector::POWER_SUPPLY => $psu,
                    PsuConnector::CONNECTOR => $connector
                ]
            );

            if (!$psuConnector) {
                $psuConnector = new PsuConnector();
                $psuConnector->setAmount($amount);
                $psuConnector->setPowerSupply($psu);
                $psuConnector->setConnector($connector);

                $this->em->persist($psuConnector);
                $this->em->flush();
            }

            $psu->addPsuConnector($psuConnector);
        }
    }
}