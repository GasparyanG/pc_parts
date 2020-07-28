<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\CoreFamily;
use App\Database\Entities\Cpu;
use App\Database\Entities\CpuImage;
use App\Database\Entities\CpuPartNumber;
use App\Database\Entities\CpuPrice;
use App\Database\Entities\CpuSeries;
use App\Database\Entities\CpuSocket;
use App\Database\Entities\IntegratedGraphic;
use App\Database\Entities\LOneCache;
use App\Database\Entities\LThreeCache;
use App\Database\Entities\LTwoCache;
use App\Database\Entities\Manufacturer;
use App\Database\Entities\Microarchitecture;
use App\Services\API\JsonApi\DataFetching\FilterImplementer;
use App\Services\API\JsonApi\Specification\Metadata;

class CPUHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Cpu::class;

    /**
     * {@inheritDoc}
     */
    public static $priceEntityName = CpuPrice::class;

    /**
     * {@inheritDoc}
     */
    public static $imageEntityName = CpuImage::class;

    /**
     * {@inheritDoc}
     */
    public static $assocName = "cpu";

    /**
     * {@inheritDoc}
     */
    public static $essentialFields = [
        "Name" => ["name", "name"],
        "Core Count" => ["coreCount", "core_count"],
        "Core Clock" => ["coreClock", "core_clock"],
        "Boost Clock" => ["boostClock", "boost_clock"],
        "TDP" => ["tdp", "tdp"],
        "SMT" => ["smt", "smt"],
        "Price" => [ResourceHandler::PRICE, ResourceHandler::PRICE]
    ];


    /**
     * {@inheritDoc}
     */
    public static $relationshipProperties = [
        CpuImage::class => "getCpuImages",
        CpuPrice::class => "getCpuPrices",
        CpuPartNumber::class => "getPartNumbers",
        Manufacturer::class => "getManufacturer",
        CpuSocket::class => "getCpuSocket",
        CpuSeries::class => "getCpuSeries",
        Microarchitecture::class => "getMicroarchitecture",
        IntegratedGraphic::class => "getIntegratedGraphic",
        CoreFamily::class => "getCoreFamily",
        LOneCache::class => "getLOneCache",
        LTwoCache::class => "getLTwoCache",
        LThreeCache::class => "getLThreeCache"
    ];

    protected function filtrationData(Metadata $meta): void
    {
        parent::filtrationData($meta);
        $this->coreClockFilter($meta);
        $this->coreCountFilter($meta);
        $this->tdpFilter($meta);
        $this->cpuSeriesFilter($meta);
        $this->cpuMicroarchitectureFilter($meta);
        $this->coreFamilyFilter($meta);
        $this->integratedGraphicFilter($meta);
    }

    protected function coreClockFilter(Metadata $meta): void
    {
        $coreClockMinAndMax = $this->repo->findCoreClockMinAndMax();

        $meta->addFiltrationData([
            Metadata::MIN => floor($coreClockMinAndMax[Metadata::MIN]) ?? 0,
            Metadata::MAX => round($coreClockMinAndMax[Metadata::MAX]) ?? 0,
            Metadata::TYPE => Metadata::RANGE,
            Metadata::GROUPING => Metadata::RANGE_GROUPING,
            Metadata::NAME => "Core Clock",
            Metadata::FIELD => "core_clock",
            Metadata::OPERATOR => strtolower(FilterImplementer::BETWEEN)
        ]);
    }

    protected function coreCountFilter(Metadata $meta): void
    {
        $coreCountMinAndMax = $this->repo->findCoreCountMinAndMax();

        $meta->addFiltrationData([
            Metadata::MIN => $coreCountMinAndMax[Metadata::MIN] ?? 0,
            Metadata::MAX => $coreCountMinAndMax[Metadata::MAX] ?? 0,
            Metadata::TYPE => Metadata::RANGE,
            Metadata::GROUPING => Metadata::RANGE_GROUPING,
            Metadata::NAME => "Core Count",
            Metadata::FIELD => "core_count",
            Metadata::OPERATOR => strtolower(FilterImplementer::BETWEEN)
        ]);
    }

    protected function tdpFilter(Metadata $meta): void
    {
        $tdpMinAndMax = $this->repo->findTdpMinAndMax();

        $meta->addFiltrationData([
            Metadata::MIN => $tdpMinAndMax[Metadata::MIN] ?? 0,
            Metadata::MAX => $tdpMinAndMax[Metadata::MAX] ?? 0,
            Metadata::TYPE => Metadata::RANGE,
            Metadata::GROUPING => Metadata::RANGE_GROUPING,
            Metadata::NAME => "TDP",
            Metadata::FIELD => "tdp",
            Metadata::OPERATOR => strtolower(FilterImplementer::BETWEEN)
        ]);
    }

    protected function cpuSeriesFilter(Metadata $meta): void
    {
        $series = $this->repo->findSeriesTypes();

        $meta->addFiltrationData([
            Metadata::COLLECTION => $series,
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "Series",
            Metadata::FIELD => "cpu_series_id",
            Metadata::OPERATOR => strtolower(FilterImplementer::IN)
        ]);
    }

    protected function cpuMicroarchitectureFilter(Metadata $meta): void
    {
        $microarchitectures = $this->repo->findMicroarchitectureTypes();

        $meta->addFiltrationData([
            Metadata::COLLECTION => $microarchitectures,
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "Microarchitecture",
            Metadata::FIELD => "microarchitecture_id",
            Metadata::OPERATOR => strtolower(FilterImplementer::IN)
        ]);
    }

    protected function coreFamilyFilter(Metadata $meta): void
    {
        $coreFamilies = $this->repo->findCoreFamilyTypes();

        $meta->addFiltrationData([
            Metadata::COLLECTION => $coreFamilies,
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "Core Family",
            Metadata::FIELD => "core_family_id",
            Metadata::OPERATOR => strtolower(FilterImplementer::IN)
        ]);
    }

    protected function integratedGraphicFilter(Metadata $meta): void
    {
        $integratedGraphics = $this->repo->findIntegratedGraphicsTypes();

        $meta->addFiltrationData([
            Metadata::COLLECTION => $integratedGraphics,
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "Integrated Graphics",
            Metadata::FIELD => "integrated_graphic_id",
            Metadata::OPERATOR => strtolower(FilterImplementer::IN)
        ]);
    }
}