<?php


namespace App\Controllers;


use App\Services\API\JsonApi\MemoryHandler;
use App\Services\API\JsonApi\Specification\MemoryComposer;

class Memory extends AbstractController
{
    /**
     * {@inheritDoc}
     */
    protected static $composer = MemoryComposer::class;

    /**
     * {@inheritDoc}
     */
    protected  static $handler = MemoryHandler::class;
}