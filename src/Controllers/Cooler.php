<?php


namespace App\Controllers;


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
}