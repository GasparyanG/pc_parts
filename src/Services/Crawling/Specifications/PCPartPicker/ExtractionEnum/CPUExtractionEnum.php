<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\ExtractionEnum;


class CPUExtractionEnum
{
    // Required subtitle (section)
    const SPECIFICATIONS = "Specifications";

    // Headers to extract
    const MANUFACTURER = "Manufacturer";
    const MODEL = "Model";
    const PART_NUMBER = "Part #";
    const CORE_COUNT = "Core Count";
    const CORE_CLOCK = "Core Clock";
    const BOOST_CLOCK = "Boost Clock";
    const TDP = "TDP";
    const SERIES = "Series";
    const MICROARCHITECTURE = "Microarchitecture";
    const CORE_FAMILY = "Core Family";
    const SOCKET = "Socket";
    const INTEGRATED_GRAPHICS = "Integrated Graphics";
    const MAXIMUM_SUPPORTED_MEMORY = "Maximum Supported Memory";
    const ECC_SUPPORT = "ECC Support";
    const PACKAGING = "Packaging";
    const INCLUDES_CPU_COOLER = "Includes CPU Cooler";
    const L1_CACHE = "L1 Cache";
    const L2_CACHE = "L2 Cache";
    const L3_CACHE = "L3 Cache";
    const LITHOGRAPHY = "Lithography";
    const SIMULTANEOUS_MULTITHREADING = "Simultaneous Multithreading";

    // Keys to refer afterwards
    static $mapping = [
        self::MANUFACTURER => "manufacturer",
        self::MODEL => "model",
        self::PART_NUMBER => "part_number",
        self::CORE_COUNT => "core_count",
        self::CORE_CLOCK => "core_clock",
        self::BOOST_CLOCK => "color",
        self::TDP => "tdp",
        self::SERIES => "series",
        self::MICROARCHITECTURE => "microarchitecture",
        self::CORE_FAMILY => "core_family",
        self::SOCKET => "socket",
        self::INTEGRATED_GRAPHICS => "integrated_graphics",
        self::MAXIMUM_SUPPORTED_MEMORY => "maximum_supported_memory",
        self::ECC_SUPPORT => "ecc_support",
        self::PACKAGING => "packaging",
        self::INCLUDES_CPU_COOLER => "includes_cpu_cooler",
        self::L1_CACHE => "l_one_cache",
        self::L2_CACHE => "l_two_cache",
        self::L3_CACHE => "l_three_cache",
        self::LITHOGRAPHY => "lithography",
        self::SIMULTANEOUS_MULTITHREADING => "simultaneous_multithreading"
    ];

    static public function get_key(string $header): ?string
    {
        return self::$mapping[$header] ?? null;
    }
}
