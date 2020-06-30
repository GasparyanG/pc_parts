<?php


namespace App\Services\API\JsonApi;


use App\Database\Entities\Cpu;

class CPUHandler extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static $entityName = Cpu::class;

    public function attributes(int $id): array
    {
        return $this->repo->findAsArray($id);
    }

    public function relationships(int $id): array
    {
        // TODO: Implement relationships() method.
        return [];
    }

    public function included(?string $relToInclude, int $id): array
    {
        // TODO: Implement included() method.
        return [];
    }
}