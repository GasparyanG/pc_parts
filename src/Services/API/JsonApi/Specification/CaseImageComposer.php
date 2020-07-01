<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\CaseImage;

class CaseImageComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = CaseImage::class;
}