<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\ExtractionEnum;


class CaseExtractionEnum
{
    // Required subtitle (section)
    const SPECIFICATIONS = "Specifications";

    // Headers to extract
    const MANUFACTURER = "Manufacturer";
    const PART_NUMBER = "Part #";
    const FORM_FACTOR = "Motherboard Form Factor";
    const TYPE = "Type";
    const COLOR = "Color";
    const POWER_SUPPLY = "Power Supply";
    const SIDE_PANEL_WINDOW = "Side Panel Window";
    const POWER_SUPPLY_SHROUD = "Power Supply Shroud";
    const FRONT_PANEL_USB = "Front Panel USB";
    const MOTHERBOARD_FORM_FACTOR = "Motherboard Form Factor";
    const FULL_HEIGHT_EXPANSION_SLOTS = "Full-Height Expansion Slots";
    const HALF_HEIGHT_EXPANSION_SLOTS = "Half-Height Expansion Slots";
    const MAXIMUM_VIDEO_CARD_LENGTH = "Maximum Video Card Length";
    const DIMENSIONS = "Dimensions";
    const INTERNAL_2_5_BAYS = "Internal 2.5\" Bays";
    const INTERNAL_3_5_BAYS = "Internal 3.5\" Bays";
    const EXTERNAL_5_2_5_BAYS = "External 5.25\" Bays";
    const VOLUME = "Volume";

    // Keys to refer afterwards
    static $mapping = [
        self::MANUFACTURER => "manufacturer",
        self::PART_NUMBER => "part_number",
        self::FORM_FACTOR => "form_factor",
        self::TYPE => "type",
        self::COLOR => "color",
        self::POWER_SUPPLY => "power_supply",
        self::SIDE_PANEL_WINDOW => "side_panel_window",
        self::POWER_SUPPLY_SHROUD => "power_supply_shroud",
        self::FRONT_PANEL_USB => "front_panel_usb",
        self::MOTHERBOARD_FORM_FACTOR => "motherboard_form_factor",
        self::FULL_HEIGHT_EXPANSION_SLOTS => "full_height_expansion_slots",
        self::HALF_HEIGHT_EXPANSION_SLOTS => "half_height_expansion_slots",
        self::MAXIMUM_VIDEO_CARD_LENGTH => "maximum_video_card_length",
        self::DIMENSIONS => "dimensions",
        self::INTERNAL_2_5_BAYS => "internal_2_5_bays",
        self::INTERNAL_3_5_BAYS => "internal_3_5_bays",
        self::EXTERNAL_5_2_5_BAYS => "external_5_2_5_bays",
        self::VOLUME => "volume"
    ];

    static $expansion_types = [
        "full_height_expansion_slots" => "Full-Height",
        "half_height_expansion_slots" => "Half-Height"
    ];

    static $bays = [
        "internal_2_5_bays" => ["Internal", 2.5],
        "internal_3_5_bays" => ["Internal", 3.5],
        "external_5_2_5_bays" => ["External", 5.25]
    ];

    static public function get_key(string $header): ?string
    {
        return self::$mapping[$header] ?? null;
    }
}