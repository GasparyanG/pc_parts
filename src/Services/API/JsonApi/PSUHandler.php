<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\Color;
use App\Database\Entities\EfficiencyRating;
use App\Database\Entities\Manufacturer;
use App\Database\Entities\PowerSupply;
use App\Database\Entities\PsuConnector;
use App\Database\Entities\PsuFormFactor;
use App\Database\Entities\PsuImage;
use App\Database\Entities\PsuPartNumber;
use App\Database\Entities\PsuPrice;
use App\Services\API\JsonApi\DataFetching\FilterImplementer;
use App\Services\API\JsonApi\Specification\Metadata;

class PSUHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    protected static $partName = "Power Supply";

    /**
     * {@inheritDoc}
     */
    public static $entityName = PowerSupply::class;

    /**
     * {@inheritDoc}
     */
    public static $priceEntityName = PsuPrice::class;

    /**
     * {@inheritDoc}
     */
    public static $imageEntityName = PsuImage::class;

    /**
     * {@inheritDoc}
     */
    public static $assocName = "psu";

    /**
     * {@inheritDoc}
     */
    public static $essentialFields = [
        "Name" => ["name","name"],
        "Wattage" => ["wattage","wattage", "W"],
        "Modular" => ["modular","modular"],
        "Form Factor" => ["formFactor", "form_factor"],
        "Color" => ["color", "color"],
        "Efficiency Rating" => ["efficiencyRating", "efficiency_rating"],
        "Price" => [ResourceHandler::PRICE,ResourceHandler::PRICE, "$"]
    ];

    public function attributes(int $id): array
    {
        $attr = parent::attributes($id);

        $psu = $this->em->getRepository(self::$entityName)->find($id);
        if ($psu) {
            $attr["color"] = $this->prepareColors($psu);
            if ($psu->getPsuFormFactor())
                $attr["formFactor"] = $psu->getPsuFormFactor()->getType();
            if ($psu->getEfficiencyRating())
                $attr["efficiencyRating"] = $psu->getEfficiencyRating()->getRating();
        }

        return $attr;
    }

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [
        PsuImage::class => "getPsuImages",
        PsuPrice::class => "getPsuPrices",
        PsuPartNumber::class => "getPartNumbers",
        Color::class => "getColors",
        PsuConnector::class => "getPsuConnectors",
        Manufacturer::class => "getManufacturer",
        PsuFormFactor::class => "getPsuFormFactor",
        EfficiencyRating::class => "getEfficiencyRating"
    ];

    protected function filtrationData(Metadata $meta): void
    {
        parent::filtrationData($meta);
        $this->efficiencyRatingFilter($meta);
        $this->wattageFilter($meta);
        $this->lengthFilter($meta);
        $this->colorFilter($meta);
//        $this->fanlessFilter($meta);
        $this->modularityFilter($meta);
    }

    protected function efficiencyRatingFilter(Metadata $meta)
    {
        $effRatings = $this->repo->findEfficiencyRatings();

        $meta->addFiltrationData([
            Metadata::COLLECTION => $effRatings,
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "Efficiency Rating",
            Metadata::FIELD => "efficiency_rating_id",
            Metadata::OPERATOR => strtolower(FilterImplementer::IN)
        ]);
    }

    protected function wattageFilter(Metadata $meta): void
    {
        $wattageMinAndMax = $this->repo->findWattageMinAndMax();

        $meta->addFiltrationData([
            Metadata::MIN => $wattageMinAndMax[Metadata::MIN] ?? 0,
            Metadata::MAX => $wattageMinAndMax[Metadata::MAX] ?? 0,
            Metadata::TYPE => Metadata::RANGE,
            Metadata::GROUPING => Metadata::RANGE_GROUPING,
            Metadata::STEP => 10,
            Metadata::NAME => "Wattage",
            Metadata::FIELD => "wattage",
            Metadata::OPERATOR => strtolower(FilterImplementer::BETWEEN)
        ]);
    }

    protected function lengthFilter(Metadata $meta): void
    {
        $lengthMinAndMax = $this->repo->findLengthMinAndMax();

        $meta->addFiltrationData([
            Metadata::MIN => $lengthMinAndMax[Metadata::MIN] ?? 0,
            Metadata::MAX => $lengthMinAndMax[Metadata::MAX] ?? 0,
            Metadata::TYPE => Metadata::RANGE,
            Metadata::GROUPING => Metadata::RANGE_GROUPING,
            Metadata::STEP => 5,
            Metadata::NAME => "Length",
            Metadata::FIELD => "length",
            Metadata::OPERATOR => strtolower(FilterImplementer::BETWEEN)
        ]);
    }

    protected function modularityFilter(Metadata $meta): void
    {
        $modularity = $this->repo->findModularity();

        $meta->addFiltrationData([
            Metadata::COLLECTION => $modularity,
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "Modular",
            Metadata::FIELD => "modular",
            Metadata::OPERATOR => strtolower(FilterImplementer::IN)
        ]);
    }

//    protected function fanlessFilter(Metadata $meta): void
//    {
//        $meta->addFiltrationData([
//            Metadata::COLLECTION => [["id" => 0, "name" => "No"], ["id" => 1, "name" => "Yes"]],
//            Metadata::TYPE => Metadata::CHECKBOX,
//            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
//            Metadata::NAME => "Fanless",
//            Metadata::FIELD => "fanless",
//            Metadata::OPERATOR => strtolower(FilterImplementer::IN)
//        ]);
//    }
}