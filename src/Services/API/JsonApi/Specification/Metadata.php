<?php


namespace App\Services\API\JsonApi\Specification;


class Metadata
{
    const ESSENTIAL_FIELDS = "essential_fields";

    /**
     * @var array
     */
    private $essentialFields = [];

    /**
     * @var array
     */
    private $representation = [];

    public function arrayRepresentation(): void
    {
        $this->representation[self::ESSENTIAL_FIELDS] = $this->essentialFields;
    }

    /**
     * @return array
     */
    public function getEssentialFields(): array
    {
        return $this->essentialFields;
    }

    /**
     * @param array $essentialFields
     */
    public function setEssentialFields(array $essentialFields): void
    {
        $this->essentialFields = $essentialFields;
    }

    /**
     * @return array
     */
    public function getRepresentation(): array
    {
        return $this->representation;
    }

    /**
     * @param array $representation
     */
    public function setRepresentation(array $representation): void
    {
        $this->representation = $representation;
    }
}
