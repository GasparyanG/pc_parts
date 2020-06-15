<?php


namespace App\Services\Crawling\Specifications\PCPartPicker\ExtractionEnum;


class MOBOExtractionEnum
{
    // Required subtitle (section)
    const SPECIFICATIONS = "Specifications";

    // Headers to extract
    const MANUFACTURER = "Manufacturer";
    const PART_NUMBER = "Part #";
    const FORM_FACTOR = "Form Factor";
    const CPU_SOCKET = "Socket / CPU";
    const CHIPSET = "Chipset";
    const MEMORY_MAX = "Memory Max";
    const MODULAR = "Modular";
    const MEMORY_TYPE = "Memory Type";
    const MEMORY_SLOTS = "Memory Slots";
    const MEMORY_SPEED = "Memory Speed";
    const COLOR = "Color";
    const SLI_CROSSFIRE = "SLI/CrossFire";
    const PCIE_16 = "PCI-E x16 Slots";
    const PCIE_8 = "PCI-E x8 Slots";
    const PCIE_4 = "PCI-E x4 Slots";
    const PCIE_1 = "PCI-E x1 Slots";
    const PCI = "PCI Slots";
    const M_DOT_2 = "M.2 Slots";
    const M_SATA = "mSATA Slots";
    const ONBOARD_ETHERNET = "Onboard Ethernet";
    const SATA_6_GB = "SATA 6 Gb/s";
    const SATA_3_GB = "SATA 3 Gb/s";
    const SATA_EXPRESS = "SATA Express";
    const ONBOARD_VIDEO = "Onboard Video";
    const USB_2_0 = "USB 2.0 Headers";
    const USB_3_2_GEN_1 = "USB 3.2 Gen 1 Headers";
    const USB_3_2_GEN_2 = "USB 3.2 Gen 2 Headers";
    const USB_3_2_GEN_2_x_2 = "USB 3.2 Gen 2x2 Headers";
    const SUPPORTS_ECC = "Supports ECC";
    const WIRELESS_NETWORKING = "Wireless Networking";
    const RAID_SUPPORT = "RAID Support";

    // Keys to refer afterwards
    static $mapping = [
        self::MANUFACTURER => "manufacturer",
        self::PART_NUMBER => "part_number",
        self::FORM_FACTOR => "form_factor",
        self::CPU_SOCKET => "cpu_socket",
        self::CHIPSET => "chipset",
        self::MEMORY_MAX => "memory_max",
        self::MODULAR => "modular",
        self::MEMORY_TYPE => "memory_type",
        self::MEMORY_SLOTS => "memory_slots",
        self::MEMORY_SPEED => "memory_speed",
        self::COLOR => "color",
        self::SLI_CROSSFIRE => "sli_crossfire",
        self::PCIE_16 => "pcie_16",
        self::PCIE_8 => "pcie_8",
        self::PCIE_4 => "pcie_4",
        self::PCIE_1 => "pcie_1",
        self::PCI => "pci",
        self::M_DOT_2 => "m_dot_2",
        self::M_SATA => "m_sata",
        self::ONBOARD_ETHERNET => "onboard_ethernet",
        self::SATA_6_GB => "sata_6_gb",
        self::SATA_3_GB => "sata_3_gb",
        self::SATA_EXPRESS => "sata_express",
        self::ONBOARD_VIDEO => "onboard_video",
        self::USB_2_0 => "usb_2_0",
        self::USB_3_2_GEN_1 => "usb_3_2_gen_1",
        self::USB_3_2_GEN_2 => "usb_3_2_gen_2",
        self::USB_3_2_GEN_2_x_2 => "usb_3_2_gen_2_x_2",
        self::SUPPORTS_ECC => "supports_ecc",
        self::WIRELESS_NETWORKING => "wireless_networking",
        self::RAID_SUPPORT => "raid_support"
    ];

    static public function get_key(string $header): ?string
    {
        return self::$mapping[$header] ?? null;
    }
}