<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\ExtractionEnum;


class GPUExtractionEnum
{
    // Required subtitle (section)
    const SPECIFICATIONS = "Specifications";

    // Headers to extract
    const MANUFACTURER = "Manufacturer";
    const PART_NUMBER = "Part #";
    const CHIPSET = "Chipset";
    const MEMORY = "Memory";
    const COLOR = "Color";
    const MEMORY_TYPE = "Memory Type";
    const CORE_CLOCK = "Core Clock";
    const BOOST_CLOCK = "Boost Clock";
    const EFFECTIVE_MEMORY_CLOCK = "Effective Memory Clock";
    const INTERFACE = "Interface";
    const SLI_CROSSFIRE = "SLI/CrossFire";
    const FRAME_SYNC = "Frame Sync";
    const LENGTH = "Length";
    const TDP = "TDP";
    const DVI_PORTS = "DVI Ports";
    const HDMI_PORTS = "HDMI Ports";
    const MINI_HDMI_PORTS = "Mini-HDMI Ports";
    const DISPLAYPORT_PORTS = "DisplayPort Ports";
    const MINI_DISPLAYPORT_PORTS = "Mini-DisplayPort Ports";
    const EXPANSION_SLOT_WIDTH = "Expansion Slot Width";
    const COOLING = "Cooling";
    const EXTERNAL_POWER = "External Power";
    const DISPLAYPORT = "DisplayPort";
    const HDMI = "HDMI";

    // Keys to refer afterwards
    static $mapping = [
        self::MANUFACTURER => "manufacturer",
        self::PART_NUMBER => "part_number",
        self::CHIPSET => "chipset",
        self::MEMORY => "memory",
        self::COLOR => "color",
        self::MEMORY_TYPE => "memory_type",
        self::CORE_CLOCK => "core_clock",
        self::BOOST_CLOCK => "boost_clock",
        self::EFFECTIVE_MEMORY_CLOCK => "effective_memory_clock",
        self::INTERFACE => "interface",
        self::SLI_CROSSFIRE => "sli_crossfire",
        self::FRAME_SYNC => "frame_sync",
        self::LENGTH => "length",
        self::TDP => "tdp",
        self::DVI_PORTS => "dvi_ports",
        self::HDMI_PORTS => "hdmi_ports",
        self::MINI_HDMI_PORTS => "mini_hdmi_ports",
        self::DISPLAYPORT_PORTS => "displayport_ports",
        self::MINI_DISPLAYPORT_PORTS => "mini_displayport_ports",
        self::EXPANSION_SLOT_WIDTH => "expansion_slot_width",
        self::COOLING => "cooling",
        self::EXTERNAL_POWER => "external_power",
        self::DISPLAYPORT => "displayport",
        self::HDMI => "hdmi"
    ];

    static $gpu_ports = [
        "dvi_ports" => "DVI",
        "hdmi_ports" => "HDMI",
        "mini_hdmi_ports" => "Mini-HDMI",
        "displayport_ports" => "DisplayPort",
        "mini_displayport_ports" => "Mini-DisplayPort"
    ];

    static public function get_key(string $header): ?string
    {
        return self::$mapping[$header] ?? null;
    }
}