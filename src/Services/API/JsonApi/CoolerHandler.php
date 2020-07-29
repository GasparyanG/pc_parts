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
        "Name" => ["name", "name"],
        "RPM" => ["rpm", "rpm_end", "RPM"],
        "Noise" => ["noise", "noise_end", "dB"],
        "Color" => ["color", "color"],
        "Price" => [ResourceHandler::PRICE, ResourceHandler::PRICE, "$"]
    ];

    public function attributes(int $id): array
    {
        $attr = parent::attributes($id);

        $cooler = $this->em->getRepository(self::$entityName)->find($id);
        if ($cooler) {
            $attr["color"] = $this->prepareColors($cooler);
            $attr["rpm"] = $this->prepareRPM($cooler);
            $attr["noise"] = $this->prepareNoise($cooler);
        }

        return $attr;
    }

    private function prepareRPM(Cooler $cooler): ?string
    {
        $rpm = "";
        if ($cooler->getRmpStart() && $cooler->getRpmEnd())
            $rpm .= $cooler->getRmpStart() . " - " . $cooler->getRpmEnd();
        else if ($cooler->getRmpStart())
            $rpm .= $cooler->getRmpStart();
        else if ($cooler->getRpmEnd())
            $rpm .= $cooler->getRpmEnd();

        return $rpm;
    }

    private function prepareNoise(Cooler $cooler): ?string
    {
        $noise = "";
        if ($cooler->getNoiseStart() && $cooler->getNoiseEnd())
            $noise .= $cooler->getNoiseStart() . " - " . $cooler->getNoiseEnd();
        else if ($cooler->getNoiseStart())
            $noise .= $cooler->getNoiseStart();
        else if ($cooler->getNoiseEnd())
            $noise .= $cooler->getNoiseEnd();

        return $noise;
    }

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
            Metadata::FIELD => "bearing_type_id",
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
            Metadata::FIELD => "water_cooled_type_id",
            Metadata::OPERATOR => strtolower(FilterImplementer::IN)
        ]);
    }
}