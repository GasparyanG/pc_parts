<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\ExtractionEnum;


class StorageExtractionEnum
{
    // Required subtitle (section)
    const SPECIFICATIONS = "Specifications";

    // Headers to extract
    const MANUFACTURER = "Manufacturer";
    const PART_NUMBER = "Part #";
    const FORM_FACTOR = "Form Factor";
    const CAPACITY = "Capacity";
    const TYPE = "Type";
    const CACHE = "Cache";
    const INTERFACE = "Interface";
    const NVME = "NVME";

    // Keys to refer afterwards
    static $mapping = [
        self::MANUFACTURER => "manufacturer",
        self::PART_NUMBER => "part_number",
        self::FORM_FACTOR => "form_factor",
        self::CAPACITY => "capacity",
        self::TYPE => "type",
        self::CACHE => "cache",
        self::INTERFACE => "interface",
        self::NVME => "nvme",
    ];

    static public function get_key(string $header): ?string
    {
        return self::$mapping[$header] ?? null;
    }
}