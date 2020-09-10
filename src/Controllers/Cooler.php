<?php


namespace App\Controllers;


use App\Database\Entities\Cooler as CoolerEntity;
use App\Services\API\JsonApi\CoolerHandler;
use App\Services\API\JsonApi\Specification\CoolerComposer;

class Cooler extends AbstractController
{
    /**
     * {@inheritDoc}
     */
    protected static $composer = CoolerComposer::class;

    /**
     * {@inheritDoc}
     */
    protected  static $handler = CoolerHandler::class;

    /**
     * {@inheritDoc}
     */
    protected static $entityName = CoolerEntity::class;
}