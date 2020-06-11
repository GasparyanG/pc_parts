<?php


namespace App\Database\Entities;


use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="cpu_sockets")
 */
class CpuSocket
{
    const TYPE = "type";

    /**
     * @var int
     * @Id
     * @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @Column(type="string", name="type")
     */
    private $type;

    /**
     * @ManyToMany(targetEntity="Cooler", mappedBy="cpuSockets")
     * @JoinTable(name="coolers_cpu_sockets",
     *      joinColumns={@JoinColumn(name="cooler_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="cpu_socket_id", referencedColumnName="id")}
     *      )
     */
    private $coolers;

    /**
     * @OneToMany(targetEntity="Cpu", mappedBy="cpuSocket")
     */
    private $cpus;

    public function __construct()
    {
        $this->coolers = new ArrayCollection();
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
     * @return mixed
     */
    public function getCoolers()
    {
        return $this->coolers;
    }

    public function addCooler(Cooler $cooler): void
    {
        if (!$this->coolers->contains($cooler)) {
            $this->coolers[] = $cooler;
            $cooler->addCpuSocket($this);
        }
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
            $cpu->setCpuSocket($this);
        }
    }
}