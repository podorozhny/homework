<?php

namespace Podorozhny\Model\Backend;

use Symfony\Component\Security\Core\Role\RoleInterface as BaseRoleInterface;

interface RoleInterface
	extends BaseRoleInterface
{
	public function getId();
}