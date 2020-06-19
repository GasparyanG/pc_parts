<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\Parts;


use App\Services\Crawling\Specifications\PCPartPicker\ExtractionEnum\CaseExtractionEnum;

class PcCase
{
    const NAME = "name";
    const URL = "url";

    const LENGTH = "length";
    const WIDTH = "width";
    const HEIGHT = "height";

    const VERSION = "version";
    const GENERATION = "generation";
    const TYPE = "type";

    const SIZE = "size";
    const CAGE = "cage";

    const FT_3_TO_LITERS = 28.31684;
    const INCH_TO_MM = 25.4;

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
     * @var array|null
     */
    private $colors = [];

    /**
     * @var array|null
     */
    private $casePartNumbers = [];

    /**
     * @var string|null
     */
    private $caseType = null;

    /**
     * @var float|null
     */
    private $powerSupply = null;

    /**
     * @var string|null
     */
    private $sidePanelWindowType = null;

    /**
     * @var bool|null
     */
    private $powerSupplyShroud = null;

    /**
     * @var array|null
     */
    private $caseDimension = [];

    /**
     * @var array|null
     */
    private $usbs = [];

    /**
     * @var array|null
     */
    private $formFactors = [];

    /**
     * @var array|null
     */
    private $expansionSlots = [];

    /**
     * @var array|null
     */
    private $bays = [];

    /**
     * @var array|null
     */
    private $caseGpuLengthTypes = [];

    /**
     * @var float|null
     */
    private $volume = null;

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
        $this->colors();
        $this->caseType();
        $this->powerSupply();
        $this->sidePanelWindowType();
        $this->powerSupplyShroud();
        $this->caseDimension();
        $this->usbs();
        $this->formFactors();
        $this->expansionSlots();
        $this->bays();
        $this->caseGpuLengthTypes();
        $this->volume();
    }

    public function toArray(): array
    {
        $dataToReturn = [];
        $dataToReturn[self::NAME] = $this->name;
        $dataToReturn[self::URL] = $this->url;
        $dataToReturn[CaseExtractionEnum::get_key(CaseExtractionEnum::COLOR)] = $this->colors;
        $dataToReturn[CaseExtractionEnum::get_key(CaseExtractionEnum::FORM_FACTOR)] = $this->formFactors;
        $dataToReturn[CaseExtractionEnum::get_key(CaseExtractionEnum::PART_NUMBER)] = $this->casePartNumbers;
        $dataToReturn[CaseExtractionEnum::get_key(CaseExtractionEnum::MANUFACTURER)] = $this->manufacturer;
        $dataToReturn[CaseExtractionEnum::get_key(CaseExtractionEnum::TYPE)] = $this->caseType;
        $dataToReturn[CaseExtractionEnum::get_key(CaseExtractionEnum::POWER_SUPPLY)] = $this->powerSupply;
        $dataToReturn[CaseExtractionEnum::get_key(CaseExtractionEnum::SIDE_PANEL_WINDOW)] = $this->sidePanelWindowType;
        $dataToReturn[CaseExtractionEnum::get_key(CaseExtractionEnum::POWER_SUPPLY_SHROUD)] = $this->powerSupplyShroud;
        $dataToReturn[CaseExtractionEnum::get_key(CaseExtractionEnum::DIMENSIONS)] = $this->caseDimension;
        $dataToReturn["usbs"] = $this->usbs;
        $dataToReturn["expansion_slots"] = $this->expansionSlots;
        $dataToReturn["bays"] = $this->bays;
        $dataToReturn[CaseExtractionEnum::get_key(CaseExtractionEnum::MAXIMUM_VIDEO_CARD_LENGTH)] = $this->caseGpuLengthTypes;
        $dataToReturn[CaseExtractionEnum::get_key(CaseExtractionEnum::VOLUME)] = $this->volume;

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
        if (isset($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::MANUFACTURER)]))
            $this->manufacturer = $this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::MANUFACTURER)];
        else
            throw new \InvalidArgumentException($this->exceptionMessage(CaseExtractionEnum::MANUFACTURER));
    }

    private function partNumbers(): void
    {
        if (isset($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::PART_NUMBER)]))
            $this->casePartNumbers = is_array($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::PART_NUMBER)])
                ? $this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::PART_NUMBER)]
                : [$this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::PART_NUMBER)]];
        else
            throw new \InvalidArgumentException($this->exceptionMessage(CaseExtractionEnum::PART_NUMBER));
    }

    private function colors(): void
    {
        if (isset($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::COLOR)]))
            $this->colors = $this->prepareColorsArray($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::COLOR)]);
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

    private function exceptionMessage(string $part): string
    {
        return "Required field: " . $part . " is absent from " . $this->name;
    }

    private function caseType(): void
    {
        if (isset($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::TYPE)]))
            $this->caseType = $this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::TYPE)];
    }

    private function powerSupply(): void
    {
        if (isset($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::POWER_SUPPLY)]))
            $this->powerSupply
                = $this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::POWER_SUPPLY)] === "None"
                ? null
                : $this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::POWER_SUPPLY)];
    }

    private function sidePanelWindowType(): void
    {
        if (isset($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::SIDE_PANEL_WINDOW)]))
            $this->sidePanelWindowType = $this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::SIDE_PANEL_WINDOW)];
    }

    private function powerSupplyShroud(): void
    {
        if (isset($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::POWER_SUPPLY_SHROUD)]))
            $this->powerSupplyShroud
                = $this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::POWER_SUPPLY_SHROUD)] === "Yes" ? true: false;
    }

    private function caseDimension(): void
    {
        if (isset($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::DIMENSIONS)]))
            if (is_array($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::DIMENSIONS)]))
                $this->caseDimension
                    = $this->prepareMM($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::DIMENSIONS)][0]);
            else
                $this->caseDimension
                    = $this->prepareMM($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::DIMENSIONS)]);
    }

    private function prepareMM(string $caseDimensions): array
    {
        $dataToReturn = [];

        // Meant to match - 428 mm x 210 mm x 460 mm - string
        $patternMM = "~^([\d.]+)\s*mm\s*x\s*([\d.]+)\s*mm\s*x\s*([\d.]+)\s*mm$~i";

        // Meant to match - 16.85" x 8.268" x 18.11" - string
        $patternInch = "~^([\d.]+)\"\s*x\s*([\d.]+)\"\s*x\s*([\d.]+)\"$~i";

        $matches = [];
        preg_match($patternMM, $caseDimensions, $matches);
        if (count($matches) > 0) {
            $dataToReturn[self::LENGTH] = $matches[1];
            $dataToReturn[self::WIDTH] = $matches[2];
            $dataToReturn[self::HEIGHT] = $matches[3];
        } else {
            preg_match($patternInch, $caseDimensions, $matches);
            if (count($matches) > 0) {
                $dataToReturn[self::LENGTH] = $matches[1] * self::INCH_TO_MM;
                $dataToReturn[self::WIDTH] = $matches[2] * self::INCH_TO_MM;
                $dataToReturn[self::HEIGHT] = $matches[3] * self::INCH_TO_MM;
            }
        }

        return $dataToReturn;
    }

    private function usbs(): void
    {
        if (isset($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::FRONT_PANEL_USB)]))
            if (is_array($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::FRONT_PANEL_USB)]))
                foreach ($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::FRONT_PANEL_USB)] as $usb)
                    $this->usbs[] = $this->prepareUsb($usb);
            else
                $this->usbs[]
                    = $this->prepareUsb($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::FRONT_PANEL_USB)]);
    }

    private function prepareUsb(string $usbString): array
    {
        $dataToReturn = [];
        $pattern = "~^USB\s*([\d.]+)(\s*Gen\s*([\d.x]+)(\s*Type-([A-Z]))?)?$~i";
        $matches = [];

        preg_match($pattern, $usbString, $matches);

        if (count($matches) === 6) {
            $dataToReturn[self::VERSION] = $matches[1];
            $dataToReturn[self::GENERATION] = $matches[3];
            $dataToReturn[self::TYPE] = $matches[5];
        } else if (count($matches) === 4) {
            $dataToReturn[self::VERSION] = $matches[1];
            $dataToReturn[self::GENERATION] = $matches[3];
            $dataToReturn[self::TYPE] = null;
        } else if (count($matches) > 0) {
            $dataToReturn[self::VERSION] = $matches[1];
            $dataToReturn[self::GENERATION] = null;
            $dataToReturn[self::TYPE] = null;
        }

        return $dataToReturn;
    }

    private function formFactors(): void
    {
        if (isset($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::FORM_FACTOR)]))
            if (is_array($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::FORM_FACTOR)]))
                foreach ($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::FORM_FACTOR)] as $formFactor)
                    $this->formFactors[] = $formFactor;
            else
                $this->formFactors[]
                    = $this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::FORM_FACTOR)];
    }

    private function expansionSlots(): void
    {
        foreach(CaseExtractionEnum::$expansion_types as $key => $etName)
            if (isset($this->scrapedData[$key]))
                $this->expansionSlots[$etName] = $this->scrapedData[$key];
    }

    private function bays(): void
    {
        foreach(CaseExtractionEnum::$bays as $key => $info)
            if (isset($this->scrapedData[$key]))
                $this->bays[] = [
                    $info[0],
                    $info[1],
                    $this->scrapedData[$key]
                ];
    }

    private function caseGpuLengthTypes(): void
    {
        if (isset($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::MAXIMUM_VIDEO_CARD_LENGTH)]))
            if (is_array($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::MAXIMUM_VIDEO_CARD_LENGTH)]))
                foreach ($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::MAXIMUM_VIDEO_CARD_LENGTH)] as $gpuLength)
                    $this->caseGpuLengthTypes[] = $this->prepareGpuLength($gpuLength);
            else
                $this->caseGpuLengthTypes[]
                    = $this->prepareGpuLength($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::MAXIMUM_VIDEO_CARD_LENGTH)]);
    }

    private function prepareGpuLength(string $gpuLength): array
    {
        $dataToReturn = [];

        $pattern = "~^([\d.]+)\s*mm\s*/\s*[\d.]+\"(\s*(With|Without)\s*Drive\s*Cages)?$~i";
        $matches = [];
        preg_match($pattern, $gpuLength, $matches);

        if (count($matches) > 0) {
            $dataToReturn[self::SIZE] = $matches[1];
            if (isset($matches[3]))
                $dataToReturn[self::CAGE] = (strtolower($matches[3]) === "with") ? true: false;
            else
                $dataToReturn[self::CAGE] = null;
        }

        return $dataToReturn;
    }

    private function volume(): void
    {
        if (isset($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::VOLUME)]))
            if (is_array($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::VOLUME)]))
                $this->volume
                    = $this->prepareVolume($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::VOLUME)][0]);
            else
                $this->volume
                    = $this->prepareVolume($this->scrapedData[CaseExtractionEnum::get_key(CaseExtractionEnum::VOLUME)]);
    }

    private function prepareVolume(string $volumeString): ?float
    {
        $patternL = "~^([\d.]+)\s*L$~i";
        $patternFt3 = "~^([\d.]+)\s*ft.$~i";

        $matches = [];
        preg_match($patternL, $volumeString, $matches);
        if (count($matches) > 0)
            return $matches[1];

        preg_match($patternFt3, $volumeString, $matches);
        if (count($matches) > 0)
            return $matches[1] * self::FT_3_TO_LITERS;

        return null;
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
    public function getColors(): ?array
    {
        return $this->colors;
    }

    /**
     * @param array|null $colors
     */
    public function setColors(?array $colors): void
    {
        $this->colors = $colors;
    }

    /**
     * @return array|null
     */
    public function getCasePartNumbers(): ?array
    {
        return $this->casePartNumbers;
    }

    /**
     * @param array|null $casePartNumbers
     */
    public function setCasePartNumbers(?array $casePartNumbers): void
    {
        $this->casePartNumbers = $casePartNumbers;
    }

    /**
     * @return string|null
     */
    public function getCaseType(): ?string
    {
        return $this->caseType;
    }

    /**
     * @param string|null $caseType
     */
    public function setCaseType(?string $caseType): void
    {
        $this->caseType = $caseType;
    }

    /**
     * @return float|null
     */
    public function getPowerSupply(): ?float
    {
        return $this->powerSupply;
    }

    /**
     * @param float|null $powerSupply
     */
    public function setPowerSupply(?float $powerSupply): void
    {
        $this->powerSupply = $powerSupply;
    }

    /**
     * @return string|null
     */
    public function getSidePanelWindowType(): ?string
    {
        return $this->sidePanelWindowType;
    }

    /**
     * @param string|null $sidePanelWindowType
     */
    public function setSidePanelWindowType(?string $sidePanelWindowType): void
    {
        $this->sidePanelWindowType = $sidePanelWindowType;
    }

    /**
     * @return bool|null
     */
    public function getPowerSupplyShroud(): ?bool
    {
        return $this->powerSupplyShroud;
    }

    /**
     * @param bool|null $powerSupplyShroud
     */
    public function setPowerSupplyShroud(?bool $powerSupplyShroud): void
    {
        $this->powerSupplyShroud = $powerSupplyShroud;
    }

    /**
     * @return array|null
     */
    public function getCaseDimension(): ?array
    {
        return $this->caseDimension;
    }

    /**
     * @param array|null $caseDimension
     */
    public function setCaseDimension(?array $caseDimension): void
    {
        $this->caseDimension = $caseDimension;
    }

    /**
     * @return array|null
     */
    public function getUsbs(): ?array
    {
        return $this->usbs;
    }

    /**
     * @param array|null $usbs
     */
    public function setUsbs(?array $usbs): void
    {
        $this->usbs = $usbs;
    }

    /**
     * @return array|null
     */
    public function getFormFactors(): ?array
    {
        return $this->formFactors;
    }

    /**
     * @param array|null $formFactors
     */
    public function setFormFactors(?array $formFactors): void
    {
        $this->formFactors = $formFactors;
    }

    /**
     * @return array|null
     */
    public function getExpansionSlots(): ?array
    {
        return $this->expansionSlots;
    }

    /**
     * @param array|null $expansionSlots
     */
    public function setExpansionSlots(?array $expansionSlots): void
    {
        $this->expansionSlots = $expansionSlots;
    }

    /**
     * @return array|null
     */
    public function getBays(): ?array
    {
        return $this->bays;
    }

    /**
     * @param array|null $bays
     */
    public function setBays(?array $bays): void
    {
        $this->bays = $bays;
    }

    /**
     * @return array|null
     */
    public function getCaseGpuLengthTypes(): ?array
    {
        return $this->caseGpuLengthTypes;
    }

    /**
     * @param array|null $caseGpuLengthTypes
     */
    public function setCaseGpuLengthTypes(?array $caseGpuLengthTypes): void
    {
        $this->caseGpuLengthTypes = $caseGpuLengthTypes;
    }

    /**
     * @return float|null
     */
    public function getVolume(): ?float
    {
        return $this->volume;
    }

    /**
     * @param float|null $volume
     */
    public function setVolume(?float $volume): void
    {
        $this->volume = $volume;
    }
}