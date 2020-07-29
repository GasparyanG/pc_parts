<?php


namespace App\Database\Entities\Metadata;


use App\Database\Entities\Motherboard;

class MOBOMeta extends AbstractMeta
{
    /**
     * {@inheritDoc}
     */
    protected $meta = [
        "price" => ["mobo_id", "mobo_prices"],
        "cpu_socket" => ["cpu_socket_id", "cpu_sockets"],
        "form_factor" => ["mobo_form_factor_id","mobo_form_factors"],
        "color" => ["motherboard_id", "motherboards_colors"]
    ];

    /**
     * {@inheritDoc}
     */
    protected $name = Motherboard::class;
}