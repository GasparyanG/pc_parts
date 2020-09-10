<?php


namespace App\Controllers;


use App\Database\Entities\Cpu as CpuEntity;
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

    /**
     * {@inheritDoc}
     */
    protected static $entityName = CpuEntity::class;
}