<?php

namespace Podorozhny\Model\Backend;

use Doctrine\Common\Collections\ArrayCollection;

class UserGroup
	implements UserGroupInterface
{
	protected $id;
	protected $createdAt;
	protected $name;
	protected $roles;
	protected $users;

	public function __construct($name = null)
	{
		if (!is_null($name)) {
			$this->name = $name;
		}
		$this->createdAt = new \DateTime();
		$this->roles     = new ArrayCollection();
		$this->users     = new ArrayCollection();
	}

	public function __toString()
	{
		return (string) $this->getName();
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

	public function getRoles()
	{
		return $this->roles;
	}

	public function getRoleNames()
	{
		$names = [];
		foreach ($this->getRoles() as $role) {
			$names[] = $role->getName();
		}

		return $names;
	}

	public function hasRole($name)
	{
		return in_array($name, $this->getRoleNames());
	}

	public function addRole(RoleInterface $role)
	{
		if (!$this->getRoles()
			->contains($role)
		) {
			$this->getRoles()
				->add($role);
		}

		return $this;
	}

	public function removeRole(RoleInterface $role)
	{
		if ($this->getRoles()
			->contains($role)
		) {
			$this->getRoles()
				->removeElement($role);
		}

		return $this;
	}

	public function getUsers()
	{
		return $this->users;
	}
}