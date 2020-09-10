<?php


namespace App\Services\API\JsonApi\Specification;


use App\Database\Entities\Motherboard;

class MoboComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    protected static $entityName = Motherboard::class;

    /**
     * {@inheritDoc}
     */
    protected static $includedParams = [
        "mobo_images",
        "motherboard_part_numbers",
        "mobo_memory_speed_types",
        "motherboards_usbs",
        "m_dot_2_types",
        "onboard_ethernet_types",
        "manufacturers",
        "cpu_sockets",
        "mobo_form_factors",
        "memory_types",
        "wireless_networking_types",
        "mobo_prices"
    ];
}