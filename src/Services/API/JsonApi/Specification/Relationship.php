<?php


namespace App\Services\API\JsonApi\Specification;


/**
 * Member of Resource
 */
class Relationship
{
    /**
     * @var array
     */
    private $representation = [];

    /**
     * @var array
     */
    private $data = [];

    /**
     * Is meant for accessing relationship data
     *
     *      author: {
     *          data: {type: "people", id: 1}
     *      }
     *
     * @var string
     */
    private $type;

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function arrayRepresentation(): void
    {
        $this->representation[$this->type][Resource::DATA] = $this->data;
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
    public function getRepresentation(): array
    {
        return $this->representation;
    }
}