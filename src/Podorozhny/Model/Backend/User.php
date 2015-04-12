<?php

namespace Podorozhny\Model\Backend;

use Doctrine\Common\Collections\ArrayCollection;

class User
	implements UserInterface
{
	protected $id;
	protected $createdAt;
	protected $username; // TODO deprecated
	protected $email;
	protected $emailCanonical;
	protected $password;
	protected $plainPassword;
	protected $salt;
	protected $enabled;
	protected $locked;
	protected $groups;
	protected $roles; // TODO deprecated
	protected $firstname;
	protected $lastname;

	public function __construct()
	{
		$this->createdAt = new \DateTime();
		$this->salt      =
			md5(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
		$this->enabled   = false;
		$this->locked    = false;
		$this->groups    = new ArrayCollection();
		$this->roles     = new ArrayCollection();
	}

	public function __toString()
	{
		return implode(' ', [$this->getLastname(), $this->getFirstname()]);
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

	/**
	 * @deprecated
	 */
	public function getUsername()
	{
		return $this->getEmail();
	}

	public function setEmail($email)
	{
		$this->email = $email;

		return $this;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setEmailCanonical($emailCanonical)
	{
		$this->emailCanonical = $emailCanonical;

		return $this;
	}

	public function getEmailCanonical()
	{
		return $this->emailCanonical;
	}

	public function setPassword($password)
	{
		$this->password = $password;

		return $this;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function setPlainPassword($password)
	{
		$this->plainPassword = $password;

		return $this;
	}

	public function getPlainPassword()
	{
		return $this->plainPassword;
	}

	public function setSalt($salt)
	{
		$this->salt = $salt;

		return $this;
	}

	public function getSalt()
	{
		return $this->salt;
	}

	public function setEnabled($enabled)
	{
		$this->enabled = (boolean) $enabled;

		return $this;
	}

	public function isEnabled()
	{
		return $this->enabled;
	}

	public function setLocked($locked)
	{
		$this->locked = (boolean) $locked;

		return $this;
	}

	public function isLocked()
	{
		return !$this->isAccountNonLocked();
	}

	public function setFirstname($firstname)
	{
		$this->firstname = $firstname;

		return $this;
	}

	public function getFirstname()
	{
		return $this->firstname;
	}

	public function setLastname($lastname)
	{
		$this->lastname = $lastname;

		return $this;
	}

	public function getLastname()
	{
		return $this->lastname;
	}

	public function getGroups()
	{
		return $this->groups;
	}

	public function getGroupNames()
	{
		$names = [];
		foreach ($this->getGroups() as $group) {
			$names[] = $group->getName();
		}

		return $names;
	}

	public function hasGroup($name)
	{
		return in_array($name, $this->getGroupNames());
	}

	public function addGroup(UserGroupInterface $group)
	{
		if (!$this->getGroups()
			->contains($group)
		) {
			$this->getGroups()
				->add($group);
		}

		return $this;
	}

	public function removeGroup(UserGroupInterface $group)
	{
		if ($this->getGroups()
			->contains($group)
		) {
			$this->getGroups()
				->removeElement($group);
		}

		return $this;
	}

	public function getRoles()
	{
		$roles = [];
		foreach ($this->getGroups() as $group) {
			$roles = array_merge($roles, $group->getRoleNames());
		}
		if (count($roles) < 1) {
			$roles[] = static::ROLE_DEFAULT;
		}

		return array_unique($roles);
	}

	public function hasRole($role)
	{
		return in_array(strtoupper($role), $this->getRoles(), true);
	}

	public function isUser(UserInterface $user = null)
	{
		return null !== $user && $this->getId() === $user->getId();
	}

	public function setSuperAdmin($boolean)
	{
		return $this;
	}

	public function isSuperAdmin()
	{
		return $this->hasRole(static::ROLE_SUPER_ADMIN);
	}

	public function serialize()
	{
		return serialize(
			[
				$this->id,
				$this->createdAt,
				$this->email,
				$this->password,
				$this->salt,
				$this->enabled,
				$this->locked,
			]
		);
	}

	public function unserialize($serialized)
	{
		$data = unserialize($serialized);
		list($this->id, $this->createdAt, $this->email, $this->password,
			$this->salt, $this->enabled, $this->locked,) = $data;
	}

	public function eraseCredentials()
	{
		$this->plainPassword = null;
	}

	public function isAccountNonExpired()
	{
		return true;
	}

	public function isAccountNonLocked()
	{
		return !$this->locked;
	}

	public function isCredentialsNonExpired()
	{
		return true;
	}

	public function isCredentialsExpired()
	{
		return !$this->isCredentialsNonExpired();
	}
}