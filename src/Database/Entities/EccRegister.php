<?php


namespace App\Database\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="ecc_registers")
 */
class EccRegister
{
    const ECC = "ecc";
    const REGISTERED = "registered";

    /**
     * @var int
     * @Id
     * @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @Column(type="string", name="ecc")
     */
    private $ecc;

    /**
     * @var string
     * @Column(type="string", name="registered")
     */
    private $registered;

    /**
     * @OneToMany(targetEntity="Memory", mappedBy="eccRegister")
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
     * @return string
     */
    public function getEcc(): string
    {
        return $this->ecc;
    }

    /**
     * @param string $ecc
     */
    public function setEcc(string $ecc): void
    {
        $this->ecc = $ecc;
    }

    /**
     * @return string
     */
    public function getRegistered(): string
    {
        return $this->registered;
    }

    /**
     * @param string $registered
     */
    public function setRegistered(string $registered): void
    {
        $this->registered = $registered;
    }

    /**
     * @return mixed
     */
    public function getMemories()
    {
        return $this->memories;
    }

    /**
     * @param Memory
     */
    public function addMemory(Memory $memory): void
    {
        if (!$this->memories->contains($memory)) {
            $this->memories[] = $memory;
            $memory->setEccRegister($this);
        }
    }
}