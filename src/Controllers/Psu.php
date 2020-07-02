<?php


namespace App\Controllers;


use App\Services\API\JsonApi\PsuHandler;
use App\Services\API\JsonApi\Specification\PsuComposer;

class Psu extends AbstractController
{
    /**
     * {@inheritDoc}
     */
    protected static $composer = PsuComposer::class;

    /**
     * {@inheritDoc}
     */
    protected  static $handler = PsuHandler::class;
}