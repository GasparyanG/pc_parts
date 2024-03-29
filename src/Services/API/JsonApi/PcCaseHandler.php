<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\CaseBay;
use App\Database\Entities\CaseDimension;
use App\Database\Entities\CaseGpuLengthType;
use App\Database\Entities\CaseImage;
use App\Database\Entities\CasePartNumber;
use App\Database\Entities\CasePrice;
use App\Database\Entities\CaseType;
use App\Database\Entities\Color;
use App\Database\Entities\ExpansionSlot;
use App\Database\Entities\Manufacturer;
use App\Database\Entities\MoboFormFactor;
use App\Database\Entities\PcCase;
use App\Database\Entities\SidePanelWindowType;
use App\Database\Entities\Usb;
use App\Services\API\JsonApi\DataFetching\FilterImplementer;
use App\Services\API\JsonApi\Specification\Metadata;

class PcCaseHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    protected static $partName = "PC Case";

    /**
     * {@inheritDoc}
     */
    public static $entityName = PcCase::class;

    /**
     * {@inheritDoc}
     */
    public static $priceEntityName = CasePrice::class;

    /**
     * {@inheritDoc}
     */
    public static $imageEntityName = CaseImage::class;

    /**
     * {@inheritDoc}
     */
    public static $assocName = "case";

    /**
     * {@inheritDoc}
     */
    public static $essentialFields = [
        "Name" => ["name", "name"],
        "Type" => ["type", "type"],
        "Color" => ["color", "color"],
        "Power Supply" => ["powerSupply", "power_supply", "W", "None"],
        "Side Panel Window" => ["sidePanelWindowType", "side_panel_window_type"],
        "Price" => [ResourceHandler::PRICE, ResourceHandler::PRICE, "$"]
    ];

    public function attributes(int $id): array
    {
        $attr = parent::attributes($id);

        $pcCase = $this->em->getRepository(self::$entityName)->find($id);
        if ($pcCase) {
            $attr["color"] = $this->prepareColors($pcCase);
            if ($pcCase->getCaseType())
                $attr["type"] = $pcCase->getCaseType()->getType();
            if ($pcCase->getSidePanelWindowType())
                $attr["sidePanelWindowType"] = $pcCase->getSidePanelWindowType()->getType();
        }

        return $attr;
    }

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
        Usb::class => "getUsbs",
        Manufacturer::class => "getManufacturer",
        CaseType::class => "getCaseType",
        SidePanelWindowType::class => "getSidePanelWindowType",
        CaseDimension::class => "getCaseDimension"
    ];

    protected function filtrationData(Metadata $meta): void
    {
        parent::filtrationData($meta);
        $this->typeFilter($meta);
        $this->sidePanelWindowFilter($meta);
        $this->colorFilter($meta);
        $this->psuShroudFilter($meta);
        $this->frontUsbFilter($meta);
        $this->moboFormFactorFilter($meta);
    }

    protected function typeFilter(Metadata $meta)
    {
        $types = $this->repo->findTypes();

        $meta->addFiltrationData([
            Metadata::COLLECTION => $types,
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "Type",
            Metadata::FIELD => "case_type_id",
            Metadata::OPERATOR => strtolower(FilterImplementer::IN)
        ]);
    }

    protected function sidePanelWindowFilter(Metadata $meta): void
    {
        $types = $this->repo->findSidePanelWindowTypes();

        $meta->addFiltrationData([
            Metadata::COLLECTION => $types,
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "Side Panel Window",
            Metadata::FIELD => "side_panel_window_type_id",
            Metadata::OPERATOR => strtolower(FilterImplementer::IN)
        ]);
    }

    protected function psuShroudFilter(Metadata $meta): void
    {
        $meta->addFiltrationData([
            Metadata::COLLECTION => [["id" => 0, "name" => "No"], ["id" => 1, "name" => "Yes"]],
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "PSU Shroud",
            Metadata::FIELD => "power_supply_shroud",
            Metadata::OPERATOR => strtolower(FilterImplementer::IN)
        ]);
    }

    protected function frontUsbFilter(Metadata $meta): void
    {
        $types = $this->repo->findFontPanelUsbTypes();

        $meta->addFiltrationData([
            Metadata::COLLECTION => $types,
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "Front Panel USB",
            Metadata::FIELD => "front_usb_filter",
            Metadata::OPERATOR => strtolower(FilterImplementer::IN)
        ]);
    }

    protected function moboFormFactorFilter(Metadata $meta): void
    {
        $types = $this->repo->findMoboFormFactorTypes();

        $meta->addFiltrationData([
            Metadata::COLLECTION => $types,
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "Motherboard Form Factor",
            Metadata::FIELD => "mobo_form_factor_filter",
            Metadata::OPERATOR => strtolower(FilterImplementer::IN)
        ]);
    }
}