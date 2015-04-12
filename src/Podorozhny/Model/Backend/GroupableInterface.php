<?php

namespace Podorozhny\Model\Backend;

interface GroupableInterface
{
	public function getGroups();

	public function getGroupNames();

	public function hasGroup($name);

	public function addGroup(UserGroupInterface $group);

	public function removeGroup(UserGroupInterface $group);
}