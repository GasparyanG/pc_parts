<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\ExtractionEnum;


class CoolerExtractionEnum
{
    // Required subtitle (section)
    const SPECIFICATIONS = "Specifications";

    // Headers to extract
    const MANUFACTURER = "Manufacturer";
    const MODEL = "Model";
    const PART_NUMBER = "Part #";
    const FAN_RPM = "Fan RPM";
    const NOISE_LEVEL = "Noise Level";
    const COLOR = "Color";
    const CPU_SOCKET = "CPU Socket";
    const WATER_COOLED = "Water Cooled";
    const FANLESS = "Fanless";
    const HEIGHT = "Height";
    const BEARING_TYPE = "Bearing";

    // Keys to refer afterwards
    static $mapping = [
        self::MANUFACTURER => "manufacturer",
        self::MODEL => "model",
        self::PART_NUMBER => "part_number",
        self::FAN_RPM => "fan_rpm",
        self::NOISE_LEVEL => "noise_level",
        self::COLOR => "color",
        self::CPU_SOCKET => "cpu_socket",
        self::WATER_COOLED => "water_cooled",
        self::FANLESS => "fanless",
        self::HEIGHT => "height",
        self::BEARING_TYPE => "bearing_type"
    ];

    static public function get_key(string $header): ?string
    {
        return self::$mapping[$header] ?? null;
    }
}