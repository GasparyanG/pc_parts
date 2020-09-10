<?php


namespace App\Services\Model\PartsGuru;


use App\Database\Entities\Cpu as CpuEntity;

class CPU extends AbstractPart
{
    /**
     * {@inheritDoc}
     */
    protected static $name = CpuEntity::class;
}