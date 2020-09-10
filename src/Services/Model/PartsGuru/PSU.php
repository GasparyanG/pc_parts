<?php


namespace App\Services\Model\PartsGuru;


use App\Database\Entities\PowerSupply;

class PSU extends AbstractPart
{
    /**
     * {@inheritDoc}
     */
    protected static $name = PowerSupply::class;
}