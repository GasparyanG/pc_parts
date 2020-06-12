<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\Parts;


use App\Services\Crawling\Specifications\PCPartPicker\ExtractionEnum\StorageExtractionEnum;

class Storage
{
    const NAME = "name";
    const URL = "url";
    const TB_TO_GB = 1000;

    /**
     * @var array
     */
    private $scrapedData = [];

    /**
     * @var null|string
     */
    private $name;

    /**
     * @var null|string
     */
    private $url;

    /**
     * @var null|string
     */
    private $manufacturer = null;

    /**
     * @var null|array
     */
    private $partNumbers = [];

    /**
     * @var null|float
     */
    private $capacity = null;

    /**
     * @var null|float
     */
    private $cache;

    /**
     * @var bool|null
     */
    private $nvme;

    /**
     * @var string|null
     */
    private $storageType;

    /**
     * @var string|null
     */
    private $storageFormFactor;

    /**
     * @var string|null
     */
    private $storageInterface;

    public function __construct(array $scrapedData)
    {
        $this->scrapedData = $scrapedData;
        $this->initialize();
    }

    private function initialize(): void
    {
        $this->name();
        $this->url();
        $this->manufacturer();
        $this->partNumbers();
        $this->capacity();
        $this->cache();
        $this->nvme();
        $this->storageType();
        $this->storageFormFactor();
        $this->storageInterface();
    }

    public function toArray(): array
    {
        $dataToReturn = [];
        $dataToReturn[self::NAME] = $this->name;
        $dataToReturn[self::URL] = $this->url;
        $dataToReturn[StorageExtractionEnum::get_key(StorageExtractionEnum::MANUFACTURER)] = $this->manufacturer;
        $dataToReturn[StorageExtractionEnum::get_key(StorageExtractionEnum::PART_NUMBER)] = $this->partNumbers;
        $dataToReturn[StorageExtractionEnum::get_key(StorageExtractionEnum::CAPACITY)] = $this->capacity;
        $dataToReturn[StorageExtractionEnum::get_key(StorageExtractionEnum::CACHE)] = $this->cache;
        $dataToReturn[StorageExtractionEnum::get_key(StorageExtractionEnum::NVME)] = $this->nvme;
        $dataToReturn[StorageExtractionEnum::get_key(StorageExtractionEnum::TYPE)] = $this->storageType;
        $dataToReturn[StorageExtractionEnum::get_key(StorageExtractionEnum::FORM_FACTOR)] = $this->storageFormFactor;
        $dataToReturn[StorageExtractionEnum::get_key(StorageExtractionEnum::INTERFACE)] = $this->storageInterface;

        return $dataToReturn;
    }

    private function name()
    {
        if (isset($this->scrapedData[self::NAME]))
            $this->name = $this->scrapedData[self::NAME];
        else
            throw new \InvalidArgumentException("Required filed: name is absent!");
    }

    private function url(): void
    {
        if (isset($this->scrapedData[self::URL]))
            $this->url = $this->scrapedData[self::URL];
        else
            throw new \InvalidArgumentException($this->exceptionMessage(self::URL));
    }

    private function manufacturer(): void
    {
        if (isset($this->scrapedData[StorageExtractionEnum::get_key(StorageExtractionEnum::MANUFACTURER)]))
            $this->manufacturer = $this->scrapedData[StorageExtractionEnum::get_key(StorageExtractionEnum::MANUFACTURER)];
        else
            throw new \InvalidArgumentException($this->exceptionMessage(StorageExtractionEnum::MANUFACTURER));
    }

    private function partNumbers(): void
    {
        if (isset($this->scrapedData[StorageExtractionEnum::get_key(StorageExtractionEnum::PART_NUMBER)]))
            $this->partNumbers = is_array($this->scrapedData[StorageExtractionEnum::get_key(StorageExtractionEnum::PART_NUMBER)])
                ? $this->scrapedData[StorageExtractionEnum::get_key(StorageExtractionEnum::PART_NUMBER)]
                : [$this->scrapedData[StorageExtractionEnum::get_key(StorageExtractionEnum::PART_NUMBER)]];
        else
            throw new \InvalidArgumentException($this->exceptionMessage(StorageExtractionEnum::PART_NUMBER));
    }

    private function capacity(): void
    {
        if (isset($this->scrapedData[StorageExtractionEnum::get_key(StorageExtractionEnum::CAPACITY)]))
            $this->capacity =
                $this->prepareCapacity($this->scrapedData[StorageExtractionEnum::get_key(StorageExtractionEnum::CAPACITY)]);
    }

    private function prepareCapacity(string $string): ?float
    {
        $pattern = "~^([\d.]+)\s*(GB|TB)$~i";
        $matches = [];

        $result = null;
        preg_match($pattern, $string, $matches);
        if (count($matches) > 0) {
            if (strtolower($matches[2]) == "tb")
                $result = $matches[1] * self::TB_TO_GB;
            else if(strtolower($matches[2]) == "gb")
                $result = $matches[1];
        }

        return $result;
    }

    private function cache(): void
    {
        if (isset($this->scrapedData[StorageExtractionEnum::get_key(StorageExtractionEnum::CACHE)]))
            $this->cache =
                $this->prepareCache($this->scrapedData[StorageExtractionEnum::get_key(StorageExtractionEnum::CACHE)]);
    }

    private function prepareCache(string $string): string
    {
        $pattern = "~^(\d+)\s*MB~i";
        $matches = [];

        preg_match($pattern, $string, $matches);
        if (count($matches) > 0)
            return $matches[1];

        return null;
    }

    private function nvme(): void
    {
        if (isset($this->scrapedData[StorageExtractionEnum::get_key(StorageExtractionEnum::NVME)]))
            $this->nvme =
                $this->supports($this->scrapedData[StorageExtractionEnum::get_key(StorageExtractionEnum::NVME)]);
    }

    private function supports(string $string): bool
    {
        $pattern = "~No.*~i";
        $matches = [];
        preg_match($pattern, $string, $matches);

        if (count($matches) > 0)
            return false;

        return true;
    }

    private function storageType(): void
    {
        if (isset($this->scrapedData[StorageExtractionEnum::get_key(StorageExtractionEnum::TYPE)]))
            $this->storageType = $this->scrapedData[StorageExtractionEnum::get_key(StorageExtractionEnum::TYPE)];
    }

    private function storageFormFactor(): void
    {
        if (isset($this->scrapedData[StorageExtractionEnum::get_key(StorageExtractionEnum::FORM_FACTOR)]))
            $this->storageFormFactor = $this->scrapedData[StorageExtractionEnum::get_key(StorageExtractionEnum::FORM_FACTOR)];
    }

    private function storageInterface(): void
    {
        if (isset($this->scrapedData[StorageExtractionEnum::get_key(StorageExtractionEnum::INTERFACE)]))
            $this->storageInterface = $this->scrapedData[StorageExtractionEnum::get_key(StorageExtractionEnum::INTERFACE)];
    }

    private function exceptionMessage(string $part): string
    {
        return "Required field: " . $part . " is absent from " . $this->name;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string|null
     */
    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    /**
     * @param string|null $manufacturer
     */
    public function setManufacturer(?string $manufacturer): void
    {
        $this->manufacturer = $manufacturer;
    }

    /**
     * @return array|null
     */
    public function getPartNumbers(): ?array
    {
        return $this->partNumbers;
    }

    /**
     * @param array|null $partNumbers
     */
    public function setPartNumbers(?array $partNumbers): void
    {
        $this->partNumbers = $partNumbers;
    }

    /**
     * @return float|null
     */
    public function getCapacity(): ?float
    {
        return $this->capacity;
    }

    /**
     * @param float|null $capacity
     */
    public function setCapacity(?float $capacity): void
    {
        $this->capacity = $capacity;
    }

    /**
     * @return float|null
     */
    public function getCache(): ?float
    {
        return $this->cache;
    }

    /**
     * @param float|null $cache
     */
    public function setCache(?float $cache): void
    {
        $this->cache = $cache;
    }

    /**
     * @return bool|null
     */
    public function getNvme(): ?bool
    {
        return $this->nvme;
    }

    /**
     * @param bool|null $nvme
     */
    public function setNvme(?bool $nvme): void
    {
        $this->nvme = $nvme;
    }

    /**
     * @return string|null
     */
    public function getStorageType(): ?string
    {
        return $this->storageType;
    }

    /**
     * @param string|null $storageType
     */
    public function setStorageType(?string $storageType): void
    {
        $this->storageType = $storageType;
    }

    /**
     * @return string|null
     */
    public function getStorageFormFactor(): ?string
    {
        return $this->storageFormFactor;
    }

    /**
     * @param string|null $storageFormFactor
     */
    public function setStorageFormFactor(?string $storageFormFactor): void
    {
        $this->storageFormFactor = $storageFormFactor;
    }

    /**
     * @return string|null
     */
    public function getStorageInterface(): ?string
    {
        return $this->storageInterface;
    }

    /**
     * @param string|null $storageInterface
     */
    public function setStorageInterface(?string $storageInterface): void
    {
        $this->storageInterface = $storageInterface;
    }
}