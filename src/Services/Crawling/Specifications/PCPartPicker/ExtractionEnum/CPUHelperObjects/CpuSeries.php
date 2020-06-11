<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\ExtractionEnum\CPUHelperObjects;


class CpuSeries
{
    const NAME = "name";

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

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

    /**
     * @return mixed
     */
    public function getCpus()
    {
        return $this->cpus;
    }

    public function toArray(): array
    {
        $dataToReturn = [];
        $dataToReturn[self::NAME] = $this->name;

        return $dataToReturn;
    }
}