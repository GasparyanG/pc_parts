<?php

namespace App\Services\Model\PartsGuru;


class PartGuruFactory
{
    private static $partGurus = [
        CPU::class,
        GPU::class,
        PSU::class
    ];

    public static function create(string $name): ?AbstractPart
    {
        foreach (self::$partGurus as $guruName)
            if ((new $guruName())->isUsed($name))
                return new $guruName();

        return null;
    }
}