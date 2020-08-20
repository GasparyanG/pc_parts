<?php


namespace App\Controllers;


use App\Services\API\JsonApi\CPUHandler;
use App\Services\API\JsonApi\Specification\CPUComposer;

class Cpu extends AbstractController
{
    /**
     * {@inheritDoc}
     */
    protected static $composer = CPUComposer::class;

    /**
     * {@inheritDoc}
     */
    protected  static $handler = CPUHandler::class;
}