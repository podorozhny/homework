<?php

namespace Podorozhny\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Podorozhny\CoreBundle\DataFixtures\DataFixture;

class BackendRoleFixture
	extends DataFixture
{
	public function load(ObjectManager $manager)
	{
		$this->createRole('ROLE_PERSONNEL');
		$this->createRole('ROLE_FINANCE');
		$this->createRole('ROLE_WAREHOUSE');
		$this->createRole('ROLE_CLIENTS');
	}

	protected function createRole($name)
	{
		$roleManager = $this->get('podorozhny.manager.backend_role');

		$role =
			$roleManager->create()
				->setName($name);

		$this->setReference('Podorozhny.Backend.Role.' . $name, $role);

		$roleManager->update($role);
	}

	public function getOrder()
	{
		return 10;
	}
}