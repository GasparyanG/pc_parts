<?php


namespace App\Controllers;


use App\Database\Entities\VideoCard;
use App\Services\API\JsonApi\GPUHandler;
use App\Services\API\JsonApi\Specification\GPUComposer;

class Gpu extends AbstractController
{
    /**
     * {@inheritDoc}
     */
    protected static $composer = GPUComposer::class;

    /**
     * {@inheritDoc}
     */
    protected  static $handler = GPUHandler::class;

    /**
     * {@inheritDoc}
     */
    protected static $entityName = VideoCard::class;
}