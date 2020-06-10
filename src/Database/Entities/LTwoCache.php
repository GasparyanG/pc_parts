<?php


namespace App\Database\Entities;


use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="l_two_caches")
 */
class LTwoCache
{
    const AMOUNT = "amount";
    const CAPACITY = "capacity";

    /**
     * @var int
     * @Id
     * @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var int|null
     * @Column(type="integer", name="amount")
     */
    private $amount;

    /**
     * @var float|null
     * @Column(type="float", name="capacity")
     */
    private $capacity;

    /**
     * @OneToMany(targetEntity="Cpu", mappedBy="LTwoCache")
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
    public function getAmount(): ?int
    {
        return $this->amount;
    }

    /**
     * @param int|null $amount
     */
    public function setAmount(?int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return float|null
     */
    public function getCapacity(): ?float
    {
        return $this->capacity;
    }

    /**
     * @param float|null $capacity
     */
    public function setCapacity(?float $capacity): void
    {
        $this->capacity = $capacity;
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
            $cpu->setLTwoCache($this);
        }
    }

    public function toArray(): array
    {
        $dataToReturn = [];
        $dataToReturn[self::AMOUNT] = $this->amount;
        $dataToReturn[self::CAPACITY] = $this->capacity;

        return $dataToReturn;
    }
}