<?php


namespace App\Services\API\JsonApi\Specification;


class Metadata
{
    const ESSENTIAL_FIELDS = "essential_fields";
    const FILTRATION = "filtration";
    const PART = "part";

    // Meant for filtration
    const COLLECTION = "collection";
    const TYPE = "type";
    const NAME = "name";
    const FIELD = "field";

    // Types
    const CHECKBOX = "checkbox";
    const RANGE = "range";
    const MIN = "min";
    const MAX = "max";

    // Grouping
    const GROUPING = "grouping";
    const CHECKBOX_GROUPING = "or";

    const RANGE_GROUPING = "and";
    // Operators
    const OPERATOR = "operator";
    const STEP = "step";
    const UNIT = "unit";

    /**
     * @var string|null
     */
    private $part = "Part";

    /**
     * @var array
     */
    private $essentialFields = [];

    /**
     * @var array
     */
    private $filtration = [];

    /**
     * @var array
     */
    private $representation = [];

    public function arrayRepresentation(): void
    {
        $this->representation[self::PART] = $this->part;
        $this->representation[self::ESSENTIAL_FIELDS] = $this->essentialFields;
        $this->representation[self::FILTRATION] = $this->filtration;
    }

    public function addFiltrationData(array $fData): void
    {
        // TODO: check for uniqueness
        $this->filtration[] = $fData;
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

    /**
     * @return string|null
     */
    public function getPart(): ?string
    {
        return $this->part;
    }

    /**
     * @param string|null $part
     */
    public function setPart(?string $part): void
    {
        $this->part = $part;
    }
}
