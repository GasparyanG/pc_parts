<?php


namespace App\Database\Entities;


use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="timings")
 */
class Timing
{
    const CAS_LATENCY = "casLatency";
    const TIMING = "timing";

    /**
     * @var int
     * @Id
     * @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var int
     * @Column(type="integer", name="cas_latency")
     */
    private $casLatency;

    /**
     * @var string
     * @Column(type="string", name="timing")
     */
    private $timing;

    /**
     * @OneToMany(targetEntity="Memory", mappedBy="timing")
     */
    private $memories;

    public function __construct()
    {
        $this->memories = new ArrayCollection();
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
     * @return int
     */
    public function getCasLatency(): ?int
    {
        return $this->casLatency;
    }

    /**
     * @param int $casLatency
     */
    public function setCasLatency(?int $casLatency): void
    {
        $this->casLatency = $casLatency;
    }

    /**
     * @return string
     */
    public function getTiming(): ?string
    {
        return $this->timing;
    }

    /**
     * @param string $timing
     */
    public function setTiming(?string $timing): void
    {
        $this->timing = $timing;
    }

    /**
     * @return mixed
     */
    public function getMemories()
    {
        return $this->memories;
    }

    public function addMemory(Memory $memory): void
    {
        if (!$this->memories->contains($memory)) {
            $this->memories[] = $memory;
            $memory->setTiming($this);
        }
    }
}