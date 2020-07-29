<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\Color;
use App\Database\Entities\EccRegister;
use App\Database\Entities\FormFactor;
use App\Database\Entities\Manufacturer;
use App\Database\Entities\Memory;
use App\Database\Entities\MemoryImage;
use App\Database\Entities\MemoryPartNumber;
use App\Database\Entities\MemoryPrice;
use App\Database\Entities\Module;
use App\Database\Entities\Timing;
use App\Services\API\JsonApi\DataFetching\FilterImplementer;
use App\Services\API\JsonApi\Specification\Metadata;

class MemoryHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Memory::class;

    /**
     * {@inheritDoc}
     */
    public static $priceEntityName = MemoryPrice::class;

    /**
     * {@inheritDoc}
     */
    public static $imageEntityName = MemoryImage::class;

    /**
     * {@inheritDoc}
     */
    public static $assocName = "memory";

    /**
     * {@inheritDoc}
     */
    public static $essentialFields = [
        "Name" => ["name", "name"],
        "Speed" => ["speed", "speed"],
        "Color" => ["color", "color"],
        "Modules" => ["modules", "modules", "GB"],
        "Cas Latency" => ["casLatency", "cas_latency"],
        "Price" => [ResourceHandler::PRICE, ResourceHandler::PRICE, "$"]
    ];

    public function attributes(int $id): array
    {
        $attr = parent::attributes($id);

        $memory = $this->em->getRepository(self::$entityName)->find($id);
        if ($memory) {
            $attr["color"] = $this->prepareColors($memory);
            $attr["modules"] = $this->prepareModules($memory);
            if ($memory->getTiming())
                $attr["casLatency"] = $memory->getTiming()->getCasLatency();
        }

        return $attr;
    }

    private function prepareModules(Memory $memory): ?string
    {
        $modulesRepr="";
        $module = $memory->getModule();
        if ($module) {
            $amount = $module->getAmount();
            $capacity = $module->getCapacity();

            $modulesRepr .= $amount . " x " .$capacity;
        }

        return $modulesRepr;
    }

    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [
        MemoryImage::class => "getMemoryImages",
        MemoryPrice::class => "getMemoryPrices",
        MemoryPartNumber::class => "getPartNumbers",
        Color::class => "getColors",
        Manufacturer::class => "getManufacturer",
        FormFactor::class => "getFormFactor",
        Module::class => "getModule",
        Timing::class => "getTiming",
        ECCRegister::class => "getECCRegister"
    ];

    protected function filtrationData(Metadata $meta): void
    {
        parent::filtrationData($meta);
        $this->formFactorFilter($meta);
        $this->speedFilter($meta);
    }

    protected function formFactorFilter(Metadata $meta): void
    {
        $formFactors = $this->repo->findFormFactors();

        $meta->addFiltrationData([
            Metadata::COLLECTION => $formFactors,
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "Form Factor",
            Metadata::FIELD => "form_factor_id",
            Metadata::OPERATOR => strtolower(FilterImplementer::IN)
        ]);
    }

    protected function speedFilter(Metadata $meta)
    {
        $speedMinAndMax = $this->repo->findSpeedMinAndMax();

        $meta->addFiltrationData([
            Metadata::MIN => $speedMinAndMax[Metadata::MIN] ?? 0,
            Metadata::MAX => $speedMinAndMax[Metadata::MAX] ?? 0,
            Metadata::TYPE => Metadata::RANGE,
            Metadata::GROUPING => Metadata::RANGE_GROUPING,
            Metadata::NAME => "Speed",
            Metadata::FIELD => "speed",
            Metadata::OPERATOR => strtolower(FilterImplementer::BETWEEN)
        ]);
    }
}