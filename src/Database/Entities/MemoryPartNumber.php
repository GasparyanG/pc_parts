<?php


namespace App\Database\Entities;


/**
 * @Entity
 * @Table(name="memory_part_numbers")
 */
class MemoryPartNumber
{
    const PART_NUMBER = "part_number";
    const MEMORY = "memory";

    /**
     * @var int
     * @Id
     * @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @Column(type="string", name="part_number")
     */
    private $part_number;

    /**
     * @var Memory
     * @ManyToOne(targetEntity="Memory", inversedBy="memory_part_numbers")
     */
    private $memory;

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
    public function getPartNumber(): string
    {
        return $this->part_number;
    }

    /**
     * @param string $part_number
     */
    public function setPartNumber(string $part_number): void
    {
        $this->part_number = $part_number;
    }

    /**
     * @return Memory
     */
    public function getMemory(): Memory
    {
        return $this->memory;
    }

    /**
     * @param Memory $memory
     */
    public function setMemory(Memory $memory): void
    {
        $this->memory = $memory;
    }
}