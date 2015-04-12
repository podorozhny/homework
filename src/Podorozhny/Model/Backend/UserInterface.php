<?php

namespace Podorozhny\Model\Backend;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;

interface UserInterface
	extends AdvancedUserInterface, \Serializable
{
	const ROLE_DEFAULT = 'ROLE_USER';

	public function getId();
}