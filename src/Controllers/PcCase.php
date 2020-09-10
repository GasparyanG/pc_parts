<?php


namespace App\Controllers;


use App\Database\Entities\PcCase as PcCaseEntity;
use App\Services\API\JsonApi\PcCaseHandler;
use App\Services\API\JsonApi\Specification\PcCaseComposer;

class PcCase extends AbstractController
{
    /**
     * {@inheritDoc}
     */
    protected static $composer = PcCaseComposer::class;

    /**
     * {@inheritDoc}
     */
    protected  static $handler = PcCaseHandler::class;

    /**
     * {@inheritDoc}
     */
    protected static $entityName = PcCaseEntity
    ::class;
}