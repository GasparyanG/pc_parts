<?php


namespace App\Database\Entities;


use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="l_one_caches")
 */
class LOneCache
{
    /**
     * @var int
     * @Id
     * @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var int|null
     * @Column(type="integer", name="instruction_amount")
     */
    private $instructionAmount;

    /**
     * @var float|null
     * @Column(type="float", name="instruction_capacity")
     */
    private $instructionCapacity;

    /**
     * @var int|null
     * @Column(type="integer", name="data_amount")
     */
    private $dataAmount;

    /**
     * @var float|null
     * @Column(type="float", name="data_capacity")
     */
    private $dataCapacity;

    /**
     * @OneToMany(targetEntity="Cpu", mappedBy="LOneCache")
     */
    private $cpus;

    public function __construct()
    {
        $this->cpus = new ArrayCollection();
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
     * @return int|null
     */
    public function getInstructionAmount(): ?int
    {
        return $this->instructionAmount;
    }

    /**
     * @param int|null $instructionAmount
     */
    public function setInstructionAmount(?int $instructionAmount): void
    {
        $this->instructionAmount = $instructionAmount;
    }

    /**
     * @return float|null
     */
    public function getInstructionCapacity(): ?float
    {
        return $this->instructionCapacity;
    }

    /**
     * @param float|null $instructionCapacity
     */
    public function setInstructionCapacity(?float $instructionCapacity): void
    {
        $this->instructionCapacity = $instructionCapacity;
    }

    /**
     * @return int|null
     */
    public function getDataAmount(): ?int
    {
        return $this->dataAmount;
    }

    /**
     * @param int|null $dataAmount
     */
    public function setDataAmount(?int $dataAmount): void
    {
        $this->dataAmount = $dataAmount;
    }

    /**
     * @return float|null
     */
    public function getDataCapacity(): ?float
    {
        return $this->dataCapacity;
    }

    /**
     * @param float|null $dataCapacity
     */
    public function setDataCapacity(?float $dataCapacity): void
    {
        $this->dataCapacity = $dataCapacity;
    }

    /**
     * @return mixed
     */
    public function getCpus()
    {
        return $this->cpus;
    }

    /**
     * @param Cpu $cpu
     */
    public function addCpu(Cpu $cpu): void
    {
        if (!$this->cpus->contains($cpu)) {
            $this->cpus[] = $cpu;
            $cpu->setLOneCache($this);
        }
    }
}