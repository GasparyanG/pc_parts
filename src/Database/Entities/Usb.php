<?php
namespace App\Database\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="usbs")
 */
class Usb 
{
    const VERSION = "version";
    const GENERATION = "generation";

    /**
     * @var int
     * @Column(type="integer", name="id")
	 * @Id
	 * @GeneratedValue
	 */
	private $id;

    /**
     * @var string
     * @Column(type="string", name="version")
	 */
	private $version;

    /**
     * @var string
     * @Column(type="string", name="generation")
	 */
	private $generation;

    /**
     * @OneToMany(targetEntity="MotherboardsUsb", mappedBy="usb")
     */
    private $motherboards;

    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
    }

    /**
     * @return int
     */
	public function getId(): int
	{
		return $this->id;
	}

    /**
     * @param int
     */
	public function setId(int $id): void
	{
		$this->id = $id;
	}

    /**
     * @return null|string
     */
	public function getVersion(): ?string
	{
		return $this->version;
	}

    /**
     * @param null|string
     */
	public function setVersion(?string $version): void
	{
		$this->version = $version;
	}

    /**
     * @return null|string
     */
	public function getGeneration(): ?string
	{
		return $this->generation;
	}

    /**
     * @param null|string
     */
	public function setGeneration(?string $generation): void
	{
		$this->generation = $generation;
	}

    /**
     * @return mixed
     */
    public function getMotherboards()
    {
        return $this->motherboards;
    }

    public function addMotherboard(MotherboardsUsb $motherboard): void
    {
        if (!$this->motherboards->contains($motherboard)) {
            $this->motherboards[] = $motherboard;
            $motherboard->setUsb($this);
        }
    }
}
