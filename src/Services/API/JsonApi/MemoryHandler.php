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
        "Name" => "name",
        "Price" => ResourceHandler::PRICE,
        "Speed" => "speed"
    ];

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
    }

    protected function formFactorFilter(Metadata $meta): void
    {
        $formFactors = $this->repo->findFormFactors();

        $meta->addFiltrationData([
            Metadata::COLLECTION => $formFactors,
            Metadata::TYPE => Metadata::CHECKBOX,
            Metadata::GROUPING => Metadata::CHECKBOX_GROUPING,
            Metadata::NAME => "Form Factor",
            Metadata::FIELD => "formFactor",
            Metadata::OPERATOR => strtolower(FilterImplementer::IN)
        ]);
    }
}