<?php


namespace App\Controllers;


use App\Database\Entities\PowerSupply;
use App\Services\API\JsonApi\PSUHandler;
use App\Services\API\JsonApi\Specification\PSUComposer;

class Psu extends AbstractController
{
    /**
     * {@inheritDoc}
     */
    protected static $composer = PSUComposer::class;

    /**
     * {@inheritDoc}
     */
    protected  static $handler = PSUHandler::class;

    /**
     * {@inheritDoc}
     */
    protected static $entityName = PowerSupply::class;
}