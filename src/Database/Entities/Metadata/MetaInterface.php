<?php


namespace App\Database\Entities\Metadata;


interface MetaInterface
{
    /**
     * Return $key related table info in SQL format (i.e. snake_case)
     *
     * @param string $key
     * @return array
     */
    public function get(string $key): array;

    /**
     * Meant for factory method[GoF]
     *
     * @param string $entityName
     * @return bool
     */
    public function isUsed(string $entityName): bool;
}