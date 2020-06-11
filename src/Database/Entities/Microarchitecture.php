<?php


namespace App\Database\Entities;


use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="microarchitectures")
 */
class Microarchitecture
{
    const NAME = "name";

    /**
     * @var int
     * @Id
     * @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @Column(type="string", name="name")
     */
    private $name;

    /**
     * @OneToMany(targetEntity="Cpu", mappedBy="microarchitecture")
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
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
            $cpu->setMicroarchitecture($this);
        }
    }

    public function toArray(): array
    {
        $dataToReturn = [];
        $dataToReturn[self::NAME] = $this->name;

        return $dataToReturn;
    }
}