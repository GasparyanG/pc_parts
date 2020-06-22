<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Database\Connection;

$em = Connection::getEntityManager();

$entity = $em->getRepository(\App\Database\Entities\PcCase::class)->find(1);
echo $entity->getName() . "\n";
echo $entity->getUrl() . "\n";
echo $entity->getManufacturer()->getName() . "\n";
echo $entity->getCaseType()->getType() . "\n";
echo $entity->getSidePanelWindowType()->getType() . "\n";
echo $entity->getCaseDimension()->getLength() . " x " . $entity->getCaseDimension()->getWidth() . " x " . $entity->getCaseDimension()->getHeight() . "\n";
echo $entity->getVolume() . "\n";

echo "\nUsbs: \n";
foreach ($entity->getUsbs() as $usb)
    echo "USB " . $usb->getVersion() . " Gen " . $usb->getGeneration() . " Type " . $usb->getType() . "\n";

echo "\nForm Factors: \n";
foreach ($entity->getFormFactors() as $ff)
    echo $ff->getType() . "\n";

echo "\nExpansion Slots: \n";
foreach ($entity->getExpansionSlots() as $es)
    echo $es->getType() . " "  . $es->getAmount() . "\n";

echo "\nCase Bays: \n";
foreach ($entity->getBays() as $bay)
    echo $bay->getType() . " " . $bay->getSize() . "\" " . $bay->getAmount() . "\n";

echo "\nCase GPU Length: \n";
foreach ($entity->getCaseGpuLengthTypes() as $clt) {
    echo $clt->getLength() . "mm ";
    $prefix = $clt->getCage() ? "With": "Without";
    echo $prefix . " Drive Cages\n";
}

echo "\nColors: \n";
foreach ($entity->getColors() as $color)
    echo $color->getName() . "\n";

echo "\nPart Number: \n";
foreach ($entity->getCasePartNumbers() as $partNumber)
    echo $partNumber->getPartNumber() . "\n";
