<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\ExtractionEnum;


class PSUExtractionEnum
{
    // Required subtitle (section)
    const SPECIFICATIONS = "Specifications";

    // Headers to extract
    const MANUFACTURER = "Manufacturer";
    const PART_NUMBER = "Part #";
    const FORM_FACTOR = "Form Factor";
    const EFFICIENCY_RATING = "Efficiency Rating";
    const WATTAGE = "Wattage";
    const LENGTH = "Length";
    const MODULAR = "Modular";
    const COLOR = "Color";
    const TYPE = "Type";
    const FANLESS = "Fanless";
    const EPS = "EPS Connectors";
    const PCIE = "PCIe 6+2-Pin Connectors";
    const SATA = "SATA Connectors";
    const MOLEX = "Molex 4-Pin Connectors";

    // Keys to refer afterwards
    static $mapping = [
        self::MANUFACTURER => "manufacturer",
        self::PART_NUMBER => "part_number",
        self::FORM_FACTOR => "form_factor",
        self::TYPE => "type",
        self::EFFICIENCY_RATING => "efficiency_rating",
        self::WATTAGE => "wattage",
        self::LENGTH => "length",
        self::MODULAR => "modular",
        self::COLOR => "color",
        self::TYPE => "type",
        self::FANLESS => "fanless",
        self::EPS => "eps",
        self::PCIE => "pcie",
        self::SATA => "sata",
        self::MOLEX => "molex"
    ];

    static public function get_key(string $header): ?string
    {
        return self::$mapping[$header] ?? null;
    }
}