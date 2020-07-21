<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\BearingType;
use App\Database\Entities\Color;
use App\Database\Entities\CoolerImage;
use App\Database\Entities\CoolerPartNumber;
use App\Database\Entities\CoolerPrice;
use App\Database\Entities\CpuSocket;
use App\Database\Entities\Cooler;
use App\Database\Entities\Manufacturer;
use App\Database\Entities\WaterCooledType;
use App\Services\API\JsonApi\DataFetching\FilterImplementer;
use App\Services\API\JsonApi\Specification\Metadata;

class CoolerHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Cooler::class;

    /**
     * {@inheritDoc}
     */
    public static $priceEntityName = CoolerPrice::class;

    /**
     * {@inheritDoc}
     */
    public static $imageEntityName = CoolerImage::class;

    /**
     * {@inheritDoc}
     */
    public static $assocName = "cooler";

    /**
     * {@inheritDoc}
     */
    public static $essentialFields = [
        "Name" => "name",
        "Price" => ResourceHandler::PRICE,
        "RPM L" => "rpm_start",
        "RPM H" => "rpm_end",
        "Noise L" => "noise_start",
        "Noise H" => "noise_end",
    ];


    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [
        CoolerImage::class => "getCoolerImages",
        CoolerPrice::class => "getCoolerPrices",
        CoolerPartNumber::class => "getPartNumbers",
        CpuSocket::class => "getCpuSockets",
        Color::class => "getColors",
        Manufacturer::class => "getManufacturer",
        BearingType::class => "getBearingType",
        WaterCooledType::class => "getWaterCooledType"
    ];

    protected function filtrationData(Metadata $meta): void
    {
        parent::filtrationData($meta);
        $this->bearingTypeFilter($meta);
        $this->waterCooledTypeFilter($meta);
    }

    protected function bearingTypeFilter(Metadata $meta): void
    {
        $bearingTypes = $this->repo->findBearingTypes();

        $meta->addFiltrationData([
            Metadata::COLLECTION => $bearingTypes,
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "Bearing Type",
            Metadata::FIELD => "bearingType",
            Metadata::OPERATOR => strtolower(FilterImplementer::IN)
        ]);
    }

    protected function waterCooledTypeFilter(Metadata $meta)
    {
        $waterCooledTypes = $this->repo->findWaterCooledTypes();

        $meta->addFiltrationData([
            Metadata::COLLECTION => $waterCooledTypes,
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "Water Cooled",
            Metadata::FIELD => "waterCooledType",
            Metadata::OPERATOR => strtolower(FilterImplementer::IN)
        ]);
    }
}