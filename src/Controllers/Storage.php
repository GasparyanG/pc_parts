<?php


namespace App\Controllers;

use App\Services\API\JsonApi\Specification\StorageComposer;
use App\Services\API\JsonApi\StorageHandler;


class Storage extends AbstractController
{
    /**
     * {@inheritDoc}
     */
    protected static $composer = StorageComposer::class;

    /**
     * {@inheritDoc}
     */
    protected  static $handler = StorageHandler::class;
}