<?php


namespace App\Services\API\JsonApi\Specification;


use App\Database\Entities\PcCase;

class PcCaseComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = PcCase::class;

    /**
     * {@inheritDoc}
     */
    protected static $includedParams = [
        "case_images",
        "case_prices",
        "case_part_numbers",
        "colors",
        "case_gpu_length_types",
        "case_bays",
        "expansion_slots",
        "mobo_form_factors",
        "usbs",
        "manufacturers",
        "case_types",
        "side_panel_window_types",
        "case_dimensions"
    ];
}