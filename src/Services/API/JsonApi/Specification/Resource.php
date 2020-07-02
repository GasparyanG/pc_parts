<?php


namespace App\Services\API\JsonApi\Specification;

/**
 * Resource implementation is based on JSON:API Specification (v1.0)
 * for more info see https://jsonapi.org/format/
 *
 * @author Garnik Gasparyan <gasp.garnik+resource.author@gmail.com>
 */
class Resource
{
    // QUERY KEYWORDS
    const PAGE= 'page';
    const PAGE_NUMBER = 'number';
    const PAGE_SIZE = 'size';

    // TOP LEVEL
    const DATA = 'data';
    const INCLUDED = 'included';

    // DATA LEVEL
    const ID = 'id';
    const TYPE = 'type';
    const ATTRIBUTES = 'attributes';
    const RELATIONSHIPS = 'relationships';

    /**
     * Representation to assemble resource in.
     * @var array
     */
    private $representation = [];

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @var array
     */
    private $relationships = [];

    /**
     * @var array
     */
    private $included = [];

    public function arrayRepresentation(): void
    {
        $this->dataLevel();
        $this->includedLevel();
    }

    private function dataLevel(): void
    {
        $this->representation[self::DATA][self::ID] = $this->id;
        $this->representation[self::DATA][self::TYPE] = $this->type;
        $this->representation[self::DATA][self::ATTRIBUTES] = $this->attributes;
        $this->representation[self::DATA][self::RELATIONSHIPS] = $this->relationships;
    }

    private function includedLevel(): void
    {
        $this->representation[self::INCLUDED] = $this->included;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    /**
     * @return array
     */
    public function getRelationships(): array
    {
        return $this->relationships;
    }

    /**
     * @param array $relationships
     */
    public function setRelationships(array $relationships): void
    {
        $this->relationships = $relationships;
    }

    /**
     * @return array
     */
    public function getIncluded(): array
    {
        return $this->included;
    }

    /**
     * @param array $included
     */
    public function setIncluded(array $included): void
    {
        $this->included = $included;
    }

    /**
     * @return array
     */
    public function getRepresentation(): array
    {
        return $this->representation;
    }
}
