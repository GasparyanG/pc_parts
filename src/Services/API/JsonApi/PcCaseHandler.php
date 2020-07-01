<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\CaseBay;
use App\Database\Entities\CaseGpuLengthType;
use App\Database\Entities\CaseImage;
use App\Database\Entities\CasePartNumber;
use App\Database\Entities\CasePrice;
use App\Database\Entities\Color;
use App\Database\Entities\ExpansionSlot;
use App\Database\Entities\MoboFormFactor;
use App\Database\Entities\PcCase;
use App\Database\Entities\Usb;

class PcCaseHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = PcCase::class;

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [
        CaseImage::class => "getCaseImages",
        CasePrice::class => "getCasePrices",
        CasePartNumber::class => "getPartNumbers",
        Color::class => "getColors",
        CaseGpuLengthType::class => "getCaseGpuLengthTypes",
        CaseBay::class => "getBays",
        ExpansionSlot::class => "getExpansionSlots",
        MoboFormFactor::class => "getFormFactors",
        Usb::class => "getUsbs"
    ];
}