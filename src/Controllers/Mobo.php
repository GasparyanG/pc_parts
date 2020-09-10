<?php


namespace App\Controllers;


use App\Database\Entities\Motherboard;
use App\Services\API\JsonApi\MoboHandler;
use App\Services\API\JsonApi\Specification\MoboComposer;

class Mobo extends AbstractController
{
    /**
     * {@inheritDoc}
     */
    protected static $composer = MoboComposer::class;

    /**
     * {@inheritDoc}
     */
    protected  static $handler = MoboHandler::class;

    /**
     * {@inheritDoc}
     */
    protected static $entityName = Motherboard::class;
}