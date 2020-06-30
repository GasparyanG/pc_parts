<?php


namespace App\Services\API\JsonApi;


abstract class ResourceHandler
{
    /**
     * @param int $id
     * @return array
     */
    abstract public function attributes(int $id): array;

    /**
     * @param int $id
     * @return array
     */
    abstract public function relationships(int $id): array;

    /**
     * @param string|null $relToInclude
     * @param int $id
     * @return array
     */
    abstract public function included(?string $relToInclude, int $id): array;
}