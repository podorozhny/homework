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
	protected $weight;
	protected $space;

	public function __construct()
	{
		$this->createdAt = new \DateTime();
		$this->count     = 0;
		$this->weight    = 0;
		$this->space     = 0;
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

	public function setWeight($weight)
	{
		$this->weight = (int) $weight;

		return $this;
	}

	public function getWeight()
	{
		return $this->weight;
	}

	public function setSpace($space)
	{
		$this->space = (int) $space;

		return $this;
	}

	public function getSpace()
	{
		return $this->space;
	}
}