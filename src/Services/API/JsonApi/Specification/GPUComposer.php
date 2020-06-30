<?php


namespace App\Services\API\JsonApi\Specification;


use App\Database\Entities\VideoCard;

class GPUComposer extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    protected static $entityName = VideoCard::class;
}