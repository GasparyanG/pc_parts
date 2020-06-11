<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\ExtractionEnum\CPUHelperObjects;


class CoreFamily
{
    const NAME = "name";

    /**
     * @var string
     */
    private $name;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function toArray(): array
    {
        $dataToReturn = [];
        $dataToReturn[self::NAME] = $this->name;

        return $dataToReturn;
    }
}