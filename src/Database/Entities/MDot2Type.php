<?php
namespace App\Database\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="m_dot_2_types")
 */
class MDot2Type 
{
    const KEY_TYPE = "keyType";
    const SIZES = "sizes";

    /**
     * @var int
     * @Column(type="integer", name="id")
	 * @Id
	 * @GeneratedValue
	 */
	private $id;

    /**
     * @var string
     * @Column(type="string", name="key_type")
	 */
	private $keyType;

    /**
     * @var float
     * @Column(type="float", name="sizes")
	 */
	private $sizes;

    /**
     * @ManyToMany(targetEntity="Motherboard", mappedBy="mDot2Types")
     * @JoinTable(name="m_dot_2_motherboards",
     *      joinColumns={@JoinColumn(name="m_dot_2_type_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="motherboard_id", referencedColumnName="id")}
     *      )
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
	public function getKeyType(): ?string
	{
		return $this->keyType;
	}

    /**
     * @param null|string
     */
	public function setKeyType(?string $keyType): void
	{
		$this->keyType = $keyType;
	}

    /**
     * @return null|float
     */
	public function getSizes(): ?float
	{
		return $this->sizes;
	}

    /**
     * @param null|float
     */
	public function setSizes(?float $sizes): void
	{
		$this->sizes = $sizes;
	}

    /**
     * @return mixed
     */
    public function getMotherboards()
    {
        return $this->motherboards;
    }

    public function addMotherboard(Motherboard $motherboard): void
    {
        if (!$this->motherboards->contains($motherboard)) {
            $this->motherboards[] = $motherboard;
            $motherboard->addMDot2Type($this);
        }
    }
}
