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
    const TYPE = "type";

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
     * @var string|null
     * @Column(type="string", name="type")
	 */
	private $type;

    /**
     * @OneToMany(targetEntity="MotherboardsUsb", mappedBy="usb")
     */
    private $motherboards;

    /**
     * @ManyToMany(targetEntity="PcCase", mappedBy="usbs")
     * @JoinTable(name="cases_usbs",
     *      joinColumns={@JoinColumn(name="usb_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="case_id", referencedColumnName="id")}
     *      )
     */
    private $cases;

    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
        $this->cases = new ArrayCollection();
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
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
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

    /**
     * @return mixed
     */
    public function getCases()
    {
        return $this->cases;
    }

    /**
     * @param PcCase $usb
     */
    public function addCase(PcCase $usb): void
    {
        if (!$this->cases->contains($usb)) {
            $this->cases[] = $usb;
            $usb->addUsb($this);
        }
    }
}
