<?php


namespace App\Database\Entities;


/**
 * @Entity
 * @Table(name="cpu_part_numbers")
 */
class CpuPartNumber
{
    const PART_NUMBER = "partNumber";
    const CPU = "cpu";

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
    private $partNumber;

    /**
     * @var Cpu
     * @ManyToOne(targetEntity="Cpu", inversedBy="cpu_part_numbers")
     */
    private $cpu;

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
        return $this->partNumber;
    }

    /**
     * @param string $part_number
     */
    public function setPartNumber(string $part_number): void
    {
        $this->partNumber = $part_number;
    }

    /**
     * @return Cpu
     */
    public function getCpu(): Cpu
    {
        return $this->cpu;
    }

    /**
     * @param Cpu $cpu
     */
    public function setCpu(Cpu $cpu): void
    {
        $this->cpu = $cpu;
    }

    public function getEntityId(): int
    {
        return $this->cpu->getId();
    }
}