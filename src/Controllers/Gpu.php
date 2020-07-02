<?php


namespace App\Controllers;


use App\Services\API\JsonApi\GpuHandler;
use App\Services\API\JsonApi\Specification\GpuComposer;

class Gpu extends AbstractController
{
    /**
     * {@inheritDoc}
     */
    protected static $composer = GpuComposer::class;

    /**
     * {@inheritDoc}
     */
    protected  static $handler = GpuHandler::class;
}