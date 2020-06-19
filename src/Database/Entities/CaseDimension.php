<?php
namespace App\Database\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="case_dimensions")
 */
class CaseDimension 
{
    const LENGTH = "length";
    const WIDTH = "width";
    const HEIGHT = "height";

    /**
     * @var int
     * @Column(type="integer", name="id")
	 * @Id
	 * @GeneratedValue
	 */
	private $id;

    /**
     * @var float
     * @Column(type="float", name="length")
	 */
	private $length;

    /**
     * @var float
     * @Column(type="float", name="width")
	 */
	private $width;

    /**
     * @var float
     * @Column(type="float", name="height")
	 */
	private $height;

    /**
     * @OneToMany(targetEntity="PcCase", mappedBy="caseDimension")
     */
    private $pcCases;

    public function __construct()
    {
        $this->pcCases = new ArrayCollection();
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
     * @return float
     */
	public function getLength(): float
	{
		return $this->length;
	}

    /**
     * @param float
     */
	public function setLength(float $length): void
	{
		$this->length = $length;
	}

    /**
     * @return float
     */
	public function getWidth(): float
	{
		return $this->width;
	}

    /**
     * @param float
     */
	public function setWidth(float $width): void
	{
		$this->width = $width;
	}

    /**
     * @return float
     */
	public function getHeight(): float
	{
		return $this->height;
	}

    /**
     * @param float
     */
	public function setHeight(float $height): void
	{
		$this->height = $height;
	}

    /**
     * @return mixed
     */
    public function getPcCases()
    {
        return $this->pcCases;
    }

    /**
     * @param PcCase $pcCase
     */
    public function addPcCase(PcCase $pcCase): void
    {
        if (!$this->pcCases->contains($pcCase)) {
            $this->pcCases[] = $pcCase;
            $pcCase->setCaseDimension($this);
        }
    }
}
