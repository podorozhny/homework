<?php

namespace Podorozhny\Model\Warehouse;

class Good
	implements GoodInterface
{
	protected $id;
	protected $createdAt;
	protected $name;
	protected $description;
	protected $count;
	protected $width;
	protected $height;
	protected $depth;
	protected $weight;

	public function __construct()
	{
		$this->createdAt = new \DateTime();
		$this->count     = 0;
		$this->width     = 0;
		$this->height    = 0;
		$this->depth     = 0;
		$this->weight    = 0;
	}

	public function __toString()
	{
		return (string) $this->getTitle();
	}

	public function getId()
	{
		return $this->id;
	}

	public function setCreatedAt(\DateTime $date = null)
	{
		$this->createdAt = $date;

		return $this;
	}

	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setDescription($description)
	{
		$this->description = $description;

		return $this;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function setCount($count)
	{
		$this->count = (int) $count;

		return $this;
	}

	public function increaseCount($count)
	{
		$this->count += (int) $count;

		return $this;
	}

	public function decreaseCount($count)
	{
		$this->count -= (int) $count;

		return $this;
	}

	public function getCount()
	{
		return $this->count;
	}

	public function setWidth($width)
	{
		$this->width = (int) $width;

		return $this;
	}

	public function getWidth()
	{
		return $this->width;
	}

	public function setHeight($height)
	{
		$this->height = (int) $height;

		return $this;
	}

	public function getHeight()
	{
		return $this->height;
	}

	public function setDepth($depth)
	{
		$this->depth = (int) $depth;

		return $this;
	}

	public function getDepth()
	{
		return $this->depth;
	}

	public function setWeight($weight)
	{
		$this->weight = (int) $weight;

		return $this;
	}

	public function getWeight()
	{
		return $this->weight;
	}
}