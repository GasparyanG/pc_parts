<?php


namespace App\Database\Entities;


/**
 * @Entity
 * @Table(name="cpu_part_numbers")
 */
class CpuPartNumber
{
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
}