<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\ExtractionEnum;


class MemoryExtractionEnum
{
    // Required subtitle (section)
    const SPECIFICATIONS = "Specifications";

    // Headers to extract
    const MANUFACTURER = "Manufacturer";
    const MODEL = "Model";
    const PART_NUMBER = "Part #";
    const FORM_FACTOR = "Form Factor";
    const MODULES = "Modules";
    const COLOR = "Color";
    const CAS_LATENCY = "CAS Latency";
    const VOLTAGE = "Voltage";
    const TIMING = "Timing";
    const ECC_REGISTERED = "ECC / Registered";
    const HEAT_SPREADER = "Heat Spreader";
    const SPEED = "Speed";

    // Keys to refer afterwards
    static $mapping = [
        self::MANUFACTURER => "manufacturer",
        self::MODEL => "model",
        self::PART_NUMBER => "part_number",
        self::FORM_FACTOR => "form_factor",
        self::MODULES => "modules",
        self::COLOR => "color",
        self::CAS_LATENCY => "cas_latency",
        self::VOLTAGE => "voltage",
        self::TIMING => "timing",
        self::ECC_REGISTERED => "ecc_registered",
        self::HEAT_SPREADER => "heat_spreader",
        self::SPEED => "speed"
    ];

    static public function get_key(string $header): ?string
    {
        return self::$mapping[$header] ?? null;
    }
}