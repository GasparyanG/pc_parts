<?php


namespace App\Controllers;


use App\Services\API\JsonApi\CpuHandler;
use App\Services\API\JsonApi\Specification\CpuComposer;

class Cpu extends AbstractController
{
    /**
     * {@inheritDoc}
     */
    protected static $composer = CpuComposer::class;

    /**
     * {@inheritDoc}
     */
    protected  static $handler = CpuHandler::class;
}