<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\Parts;


use App\Services\Crawling\Specifications\PCPartPicker\ExtractionEnum\PSUExtractionEnum;

class PSU
{
    const NAME = "name";
    const URL = "url";
    const CONNECTORS = "connectors";

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
     * @var float|null
     */
    private $wattage = null;

    /**
     * @var string|null
     */
    private $psuFormFactor = null;

    /**
     * @var string|null
     */
    private $efficiencyRating = null;

    /**
     * @var array
     */
    private $psuConnectors = [];

    /**
     * @var array
     */
    private $colors = [];

    /**
     * @var float|null
     */
    private $length = null;

    /**
     * @var bool|null
     */
    private $fanless = null;

    /**
     * @var string|null
     */
    private $modular = null;

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
        $this->wattage();
        $this->psuFormFactor();
        $this->efficiencyRating();
        $this->psuConnectors();
        $this->colors();
        $this->length();
        $this->fanless();
        $this->modular();
    }

    public function toArray()
    {
        $dataToReturn = [];
        $dataToReturn[self::NAME] = $this->name;
        $dataToReturn[self::URL] = $this->url;
        $dataToReturn[PSUExtractionEnum::get_key(PSUExtractionEnum::MANUFACTURER)] = $this->manufacturer;
        $dataToReturn[PSUExtractionEnum::get_key(PSUExtractionEnum::PART_NUMBER)] = $this->partNumbers;
        $dataToReturn[PSUExtractionEnum::get_key(PSUExtractionEnum::WATTAGE)] = $this->wattage;
        $dataToReturn[PSUExtractionEnum::get_key(PSUExtractionEnum::FORM_FACTOR)] = $this->psuFormFactor;
        $dataToReturn[PSUExtractionEnum::get_key(PSUExtractionEnum::EFFICIENCY_RATING)] = $this->efficiencyRating;
        $dataToReturn[self::CONNECTORS] = $this->psuConnectors;
        $dataToReturn[PSUExtractionEnum::get_key(PSUExtractionEnum::COLOR)] = $this->colors;
        $dataToReturn[PSUExtractionEnum::get_key(PSUExtractionEnum::LENGTH)] = $this->length;
        $dataToReturn[PSUExtractionEnum::get_key(PSUExtractionEnum::FANLESS)] = $this->fanless;
        $dataToReturn[PSUExtractionEnum::get_key(PSUExtractionEnum::MODULAR)] = $this->modular;

        return $dataToReturn;
    }

    private function name(): void
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
        if (isset($this->scrapedData[PSUExtractionEnum::get_key(PSUExtractionEnum::MANUFACTURER)]))
            $this->manufacturer = $this->scrapedData[PSUExtractionEnum::get_key(PSUExtractionEnum::MANUFACTURER)];
        else
            throw new \InvalidArgumentException($this->exceptionMessage(PSUExtractionEnum::MANUFACTURER));
    }

    private function partNumbers(): void
    {
        if (isset($this->scrapedData[PSUExtractionEnum::get_key(PSUExtractionEnum::PART_NUMBER)]))
            $this->partNumbers = is_array($this->scrapedData[PSUExtractionEnum::get_key(PSUExtractionEnum::PART_NUMBER)])
                ? $this->scrapedData[PSUExtractionEnum::get_key(PSUExtractionEnum::PART_NUMBER)]
                : [$this->scrapedData[PSUExtractionEnum::get_key(PSUExtractionEnum::PART_NUMBER)]];
        else
            throw new \InvalidArgumentException($this->exceptionMessage(PSUExtractionEnum::PART_NUMBER));
    }

    private function exceptionMessage(string $part): string
    {
        return "Required field: " . $part . " is absent from " . $this->name;
    }

    private function wattage(): void
    {
        if (isset($this->scrapedData[PSUExtractionEnum::get_key(PSUExtractionEnum::WATTAGE)]))
            $this->wattage =
                $this->prepareWattage($this->scrapedData[PSUExtractionEnum::get_key(PSUExtractionEnum::WATTAGE)]);
    }

    private function prepareWattage(string $string): ?float
    {
        $patten = "~([\d.]+)\s*W~i";
        $matches = [];
        preg_match($patten, $string, $matches);

        if (count($matches) > 0)
            return $matches[1];
        return null;
    }

    private function psuFormFactor(): void
    {
        if (isset($this->scrapedData[PSUExtractionEnum::get_key(PSUExtractionEnum::FORM_FACTOR)]))
            $this->psuFormFactor = $this->scrapedData[PSUExtractionEnum::get_key(PSUExtractionEnum::FORM_FACTOR)];
    }

    private function efficiencyRating(): void
    {
        if (isset($this->scrapedData[PSUExtractionEnum::get_key(PSUExtractionEnum::EFFICIENCY_RATING)]))
            $this->efficiencyRating = $this->scrapedData[PSUExtractionEnum::get_key(PSUExtractionEnum::EFFICIENCY_RATING)];
    }

    private function psuConnectors(): void
    {
        foreach (PSUExtractionEnum::connectors() as $key => $connectorName) {
            if (isset($this->scrapedData[$key]))
                $this->psuConnectors[$connectorName] = $this->scrapedData[$key];
        }
    }

    private function colors(): void
    {
        if (isset($this->scrapedData[PSUExtractionEnum::get_key(PSUExtractionEnum::COLOR)]))
            $this->colors = $this->prepareColorsArray($this->scrapedData[PSUExtractionEnum::get_key(PSUExtractionEnum::COLOR)]);
    }

    private function prepareColorsArray(string $stringOfColors): array
    {
        $pattern = "~((\w+)/?(.*))+~";
        $matches = [];

        $colors = [];
        preg_match($pattern, $stringOfColors, $matches);
        if (isset($matches[2])) {
            $colors[] = $matches[2];

            while (isset($matches[3]) && $matches[3] != "") {
                preg_match($pattern, $matches[3], $matches);
                $colors[] = $matches[2];
            }
        }

        return $colors;
    }

    private function length(): void
    {
        if (isset($this->scrapedData[PSUExtractionEnum::get_key(PSUExtractionEnum::LENGTH)]))
            $this->length =
                $this->prepareLength($this->scrapedData[PSUExtractionEnum::get_key(PSUExtractionEnum::LENGTH)]);
    }

    private function prepareLength(string $string): ?float
    {
        $patten = "~([\d.]+)\s*mm~i";
        $matches = [];
        preg_match($patten, $string, $matches);

        if (count($matches) > 0)
            return $matches[1];
        return null;
    }

    private function fanless(): void
    {
        if (isset($this->scrapedData[PSUExtractionEnum::get_key(PSUExtractionEnum::FANLESS)]))
            $this->fanless = $this->scrapedData[PSUExtractionEnum::get_key(PSUExtractionEnum::FANLESS)] === "No" ? false : true;
    }

    private function modular(): void
    {
        if (isset($this->scrapedData[PSUExtractionEnum::get_key(PSUExtractionEnum::MODULAR)]))
            $this->modular = $this->scrapedData[PSUExtractionEnum::get_key(PSUExtractionEnum::MODULAR)];
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
    public function getWattage(): ?float
    {
        return $this->wattage;
    }

    /**
     * @param float|null $wattage
     */
    public function setWattage(?float $wattage): void
    {
        $this->wattage = $wattage;
    }

    /**
     * @return string|null
     */
    public function getPsuFormFactor(): ?string
    {
        return $this->psuFormFactor;
    }

    /**
     * @param string|null $psuFormFactor
     */
    public function setPsuFormFactor(?string $psuFormFactor): void
    {
        $this->psuFormFactor = $psuFormFactor;
    }

    /**
     * @return string|null
     */
    public function getEfficiencyRating(): ?string
    {
        return $this->efficiencyRating;
    }

    /**
     * @param string|null $efficiencyRating
     */
    public function setEfficiencyRating(?string $efficiencyRating): void
    {
        $this->efficiencyRating = $efficiencyRating;
    }

    /**
     * @return array
     */
    public function getPsuConnectors(): array
    {
        return $this->psuConnectors;
    }

    /**
     * @param array $psuConnectors
     */
    public function setPsuConnectors(array $psuConnectors): void
    {
        $this->psuConnectors = $psuConnectors;
    }

    /**
     * @return array
     */
    public function getColors(): array
    {
        return $this->colors;
    }

    /**
     * @param array $colors
     */
    public function setColors(array $colors): void
    {
        $this->colors = $colors;
    }

    /**
     * @return float|null
     */
    public function getLength(): ?float
    {
        return $this->length;
    }

    /**
     * @param float|null $length
     */
    public function setLength(?float $length): void
    {
        $this->length = $length;
    }

    /**
     * @return bool|null
     */
    public function getFanless(): ?bool
    {
        return $this->fanless;
    }

    /**
     * @param bool|null $fanless
     */
    public function setFanless(?bool $fanless): void
    {
        $this->fanless = $fanless;
    }

    /**
     * @return string|null
     */
    public function getModular(): ?string
    {
        return $this->modular;
    }

    /**
     * @param string|null $modular
     */
    public function setModular(?string $modular): void
    {
        $this->modular = $modular;
    }
}